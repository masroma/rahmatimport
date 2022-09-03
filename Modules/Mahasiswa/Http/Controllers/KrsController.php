<?php

namespace Modules\Mahasiswa\Http\Controllers;

use App\Models\CutLockTime;
use App\Models\JatahKrs;
use App\Models\JenisSemester;
use App\Models\KelasPerkuliahan;
use App\Models\Krs;
use App\Models\Kurikulum;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\NilaiPerkuliahan;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Carbon\Carbon;
use DataTables;
use Exception;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:karturencanastudy-view|karturencanastudy-create|karturencanastudy-edit|karturencanastudy-show|karturencanastudy-delete', ['only' => ['index','store']]);
         $this->middleware('permission:karturencanastudy-view', ['only' => ['index']]);
         $this->middleware('permission:karturencanastudy-create', ['only' => ['create','store']]);
         $this->middleware('permission:karturencanastudy-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:karturencanastudy-show', ['only' => ['show']]);
         $this->middleware('permission:karturencanastudy-delete', ['only' => ['destroy']]);

    }

    public function data(){
        try{
                $user = User::where('id',Auth::user()->id)->first();
                $krsnilai = NilaiPerkuliahan::with('kelas')->where('mahasiswa_id', $user->relation_id)->get()->pluck('kelas.matakuliah_id');
                $krs = Krs::where('mahasiswa_id',$user->relation_id)->get()->pluck('matakuliah_id');
                
                $data = KelasPerkuliahan::with('matakuliah','jadwal')->whereNotIn('matakuliah_id', $krsnilai)->whereNotIn('matakuliah_id', $krs)->get();
                return DataTables::of($data)
                ->addColumn('kodekelas',function($data){
                    return $data->nama_kelas.''.$data->kode;
                })
                ->addColumn('jadwals', function($data){
                    if($data->jadwal == NULL){
                        return '-';
                    }else{
                        return $data->jadwal->hari .','. Carbon::parse($data->jadwal->jam_awal)->format('H:i') .'-'. Carbon::parse($data->jadwal->jam_akhir)->format('H:i');
                    }
                    
                })
                ->addColumn('action', function ($data)  {

                    $btn = '';
                        $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button"  onClick="addKrs('.$data->id.')"><i class="material-icons">add</i>Tambah</button>';

                    return $btn;
                            })
                            ->addIndexColumn()
                            ->make(true);

            } catch (Exception $e) {
                DB::commit();
                return response()->json(
                    [
                        'status' => false,
                        'message' => $e->getMessage()
                    ]
                );
            }

    }
    
    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $mahasiswa = Mahasiswa::with('Riwayatpendidikan.JenisSemester','Riwayatpendidikan.ProgramStudy.jurusan','Riwayatpendidikan.ProgramStudy.jenjang')->findOrFail($user->relation_id);
        $semester = JenisSemester::with('TahunAjaran')->where('active',1)->latest()->first();
        $semesterkemarin = $semester->id - 1;
        $krs = Krs::with('Mahasiswa','matakuliah','kelas','Kelas.Jadwal')->where('jenissemester_id',$semester->id)->where('mahasiswa_id',$user->relation_id)->get();
        $krssemesterkemarin = Krs::with(['NilaiKrs' => function($q) use($user){
            return $q->where('mahasiswa_id',$user->relation_id);
        },'Mahasiswa.Riwayatpendidikan.ProgramStudy.jurusan.SkalaNilai','matakuliah','kelas'])->where('jenissemester_id',$semesterkemarin)->where('mahasiswa_id',$user->relation_id)->get();
        $no = 1; 
        $totalsks = 0;
        $totalip = 0;
        $totalnilaiindex = 0;

        foreach($krssemesterkemarin as $row){
                $totalsks += $row->matakuliah->bobot_mata_kuliah;
                foreach ($row->Mahasiswa->Riwayatpendidikan->ProgramStudy->jurusan->SkalaNilai as $sn) {
                    if($sn->nilai_huruf == $row->NilaiKrs->nilai_huruf){
                        $totalnilaiindex += $sn->nilai_index * $row->matakuliah->bobot_mata_kuliah;
                    }
                }
        }
        // dd($krssemesterkemarin);
        $ips= number_format($totalnilaiindex / $totalsks, 2);
        $jatahsks = JatahKrs::all();
       
        $sks = 0;
        foreach($jatahsks as $js){
            if($ips >= $js->ip_min && $ips <= $js->ip_max){
                $sks = $js->jumlah_sks;
            }
        }
        $date = date("Y-m-d");
        $time = date("h:i:s");
        $cutoff = CutLockTime::where('tahunajaran_id', $semester->id)->where('key','krs')->first();
        return view('mahasiswa::krs.index',compact('krs','semester','mahasiswa','krssemesterkemarin','ips','sks','cutoff','date','time'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('mahasiswa::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store($id)
    {
        
        DB::beginTransaction();
        try {
            $user = User::where('id',Auth::user()->id)->first();
            $semester = JenisSemester::with('TahunAjaran')->where('active',1)->latest()->first();
            $data = KelasPerkuliahan::with('matakuliah','jadwal')->where('id', $id)->first();
            $save = new Krs();
            $save->jenissemester_id = $semester->id;
            $save->mahasiswa_id = $user->relation_id;
            $save->matakuliah_id = $data->matakuliah->id;
            $save->kelas_id = $data->id;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('karturencanastudy.index')->with(['success' => 'KRS Berhasil Ditambah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('karturencanastudy.index')->with(['error' => 'KRS Gagal Ditambah!']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('mahasiswa::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('mahasiswa::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
