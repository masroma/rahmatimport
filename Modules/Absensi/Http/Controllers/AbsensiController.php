<?php

namespace Modules\Absensi\Http\Controllers;

use App\Models\AbsensiDosen;
use App\Models\DosenPerkuliahan;
use App\Models\JadwalKelas;
use App\Models\JenisSemester;
use App\Models\Krs;
use App\Models\RuangPerkuliahan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    public function data(){
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("kelasperkuliahan-edit");
            $canDelete = Gate::allows("kelasperkuliahan-delete");
            $semester = JenisSemester::where("active",1)->latest()->first();
            $data = RuangPerkuliahan::with('kelasPerkuliahan','kelasPerkuliahan.dosen','kelasPerkuliahan.programstudy','kelasPerkuliahan.matakuliah','PenggunaanRuangs')->where('jenissemester_id', $semester->id)->orWhere("jenissemester_id",NULL)->get();

            return DataTables::of($data)
                    ->addColumn('namakelas', function($data){
                        return $data->kelasperkuliahan ? $data->kelasperkuliahan->nama_kelas.$data->kelasperkuliahan->kode : '-';
                    })

                    ->addColumn('penggunaankelas', function($data){
                        return $data->PenggunaanRuangs->penggunaan_ruangan;
                    })


                    ->addColumn('kodematakuliah', function($data){
                        return $data->kelasperkuliahan ? $data->kelasperkuliahan->matakuliah->kode_matakuliah : '-';
                    })

                    ->addColumn('namamatakuliah', function($data){
                        return $data->kelasperkuliahan ? $data->kelasperkuliahan->matakuliah->nama_matakuliah : '-';
                    })

                    ->addColumn('jamawal',function($data){
                        return Carbon::createFromFormat('H:i:s',$data->jam_awal)->format('h:i');
                    })

                    ->addColumn('jamakhir',function($data){
                        return Carbon::createFromFormat('H:i:s',$data->jam_akhir)->format('h:i');
                    })



                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $url = route('absensi.show',$data->id);
                        $btn = "";

                        // if ($canUpdate) {
                        //     $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        // }

                        // if ($canDelete) {
                        //     $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        // }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        $btn .= '<a href="'.$url.'" class="btn waves-effect waves-light purple darken-1 btn-small" type="button">Absensi</a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    "status" => false,
                    "message" => $e->getMessage()
                ]
            );
        }
    }
    public function index()
    {
        $canCreate = Gate::allows('ruangperkuliahan-create');
        $name_page = "ruangperkuliahan";
        $title = "ruang perkuliahan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('absensi::absensi.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('absensi::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $name_page = "pertemuan kelas";
        $title = "pilih pertemuan";
        $semesteraktif=JenisSemester::where('active',1)->latest()->first();
        $ruang = RuangPerkuliahan::with('kelasPerkuliahan','kelasPerkuliahan.programstudy','kelasPerkuliahan.matakuliah','PenggunaanRuangs')->where('jenissemester_id', $semesteraktif->id)->orWhere("jenissemester_id",NULL)->findOrFail($id);


        $dosen = DosenPerkuliahan::with("Dosen","Substansi")->where('kelasperkuliahan_id',$ruang->kelasperkuliahan_id)->where('jenissemester_id', $semesteraktif->id)->get();
        $semester = JadwalKelas::where('ruangperkuliahan_id', $id)->where('jenissemester_id', $semesteraktif->id)->get();


        $data = array(
            'page' => $name_page,
            "title" => $title,
            "semester" => $semester,
            "dosen" => $dosen,
            "ruang" => $ruang
        );



        return view('absensi::absensi.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $name_page = "pertemuan kelas";
        $title = "pilih pertemuan";
        $jadwal = JadwalKelas::findOrFail($id);
        $absensidosen = AbsensiDosen::where('jadwalkelas_id', $jadwal->id)->first();

        $data = array(
            'page' => $name_page,
            "title" => $title,
            "jadwal" => $jadwal,
            "absensidosen" => $absensidosen,
            "id" => $id
        );
        return view('absensi::absensi.edit')->with($data);
    }

    public function dataMahasiswa($id)
    {
        try {
            $jadwal = JadwalKelas::findOrFail($id);
            $semesteraktif=JenisSemester::where('active',1)->latest()->first();
            $ruang = RuangPerkuliahan::findOrFail($jadwal->ruangperkuliahan_id);
            $data = Krs::with(['mahasiswa.Absen' => function($a) use($jadwal, $ruang){
                 return $a->where('pertemuan','=',$jadwal->pertemuan_ke)->where('ruangperkuliahan_id', $ruang->id);
            }])->where('kelas_id', $ruang->kelasperkuliahan_id)->where('jenissemester_id',$semesteraktif->id)->whereIn('status',['menunggu','disetujui'])->get();


            return DataTables::of($data)
                    ->addColumn('nim', function($data){
                        return $data->mahasiswa->nim;
                    })

                    ->addColumn('nama', function($data){
                        return $data->mahasiswa->nama;
                    })

                    ->addColumn('status', function($data){

                        if($data->mahasiswa->Absen == null){
                            return "<span style='color:red'>alfa</span>";
                        }else{
                            return "<span style='color:green'>hadir</span>";
                        }
                    })

                    ->rawColumns(['action','status'])
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    "status" => false,
                    "message" => $e->getMessage()
                ]
            );
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'tanggal_perkuliahan' => 'required',
                'jam_masuk' => 'required',
                'jam_keluar' => 'required',
            ]);

            $update = JadwalKelas::find($id);
            $update->tanggal_perkuliahan = $request->tanggal_perkuliahan;
            $update->jam_masuk = $request->jam_masuk;
            $update->jam_keluar = $request->jam_keluar;
            $update->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


        if ($update) {
            //redirect dengan pesan sukses
            return redirect()->route('absensi.edit',$id)->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('absensi.edit',$id)->with(['error' => 'Data Gagal Diubah!']);
        }
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
