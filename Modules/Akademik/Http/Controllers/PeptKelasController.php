<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\JenisSemester;
use App\Models\KelasPerkuliahan;
use App\Models\PenggunaanRuangan;
use App\Models\PeptBatch;
use App\Models\PeptKelas;
use App\Models\RuangGedung;
use App\Models\RuangPerkuliahan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Carbon\Carbon;
use Gate;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PeptKelasController extends Controller
{

     /**
     * Display a listing of the resource.
     * @return Renderable
     */


    use ValidatesRequests;

    // function __construct()
    // {
    //      $this->middleware('permission:peptkelas-view|peptkelas-create|peptkelas-edit|peptkelas-show|peptkelas-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:peptkelas-view', ['only' => ['index']]);
    //      $this->middleware('permission:peptkelas-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:peptkelas-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:peptkelas-show', ['only' => ['show']]);
    //      $this->middleware('permission:peptkelas-delete', ['only' => ['destroy']]);

    // }

    public function data()
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("ruangperkuliahan-edit");
            $canDelete = Gate::allows("ruangperkuliahan-delete");
            $data = RuangGedung::with('Perkuliahan','listkampus','Pept')->withCount(['Perkuliahan','Pept'])->get();
            return DataTables::of($data)
            ->addColumn('kampus',function($data){
                return $data->ListKampus->cabang_kampus;
            })
            ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";
                        $url = route('peptkelas.calendar',$data->id);

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">remove_red_eye</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }



                        return $btn;
                    })
                    ->rawColumns(['colors','action'])
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
        $canCreate = Gate::allows('peptkelas-create');
        $name_page = "peptkelas";
        $title = "PEPT Kelas";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::peptkelas.index')->with($data);
    }

    public function calendar($id)
    {
        $semesteraktif = JenisSemester::where('active',1)->first();
        $getIdKelas = RuangPerkuliahan::where('jenissemester_id',$semesteraktif->id)->where('penggunaanruang_id',1)->get()->pluck('kelasperkuliahan_id');
        $getIdPept = RuangPerkuliahan::where('jenissemester_id',$semesteraktif->id)->where('penggunaanruang_id',6)->get()->pluck('pept_id');

        $getkelas = KelasPerkuliahan::WhereNotIn('id', $getIdKelas)->get();
        $getpept = PeptBatch::whereNotIn('id',$getIdPept)->get();

        $name_page = "ruangperkuliahan";
        $title = "Management Ruangan";

        $data = array(
            'page' => $name_page,
            "title" => $title,
            'getkelas'=>$getkelas,
            'getpept' => $getpept,
            'idruangan' => $id,
            'pept' => true
        );
        return view('akademik::peptkelas.calendar')->with($data);
    }

    private function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $lauch = explode($delimiters[0], $ready);

        return $lauch;
    }

    public function insertCalendar(Request $request){


        $tanggalmulai = Carbon::parse($request->tanggalawalmasuk)->format("Y-m-d H:i:s");
        $semesteraktif= JenisSemester::where('active',1)->first();


        DB::beginTransaction();
        try {


            $minute = 120;

            $get = substr($request->jamawal, 0,8);
            $timeAkhir = date('H:i:s', strtotime($get. ' +'.$minute.' minutes'));
            $open_time = strtotime($request->jamawal);

            $close_time = $timeAkhir;

            $output = "";
            for ($i = $open_time; $i <= $close_time; $i+= 300) {
                $output .= date('H:i',$i)." ";
            }

            $ar = explode(" ",$output);
            $waktu = json_encode($ar);

            $cektype = PenggunaanRuangan::findOrFail($request->penggunaanruang);
            if($cektype->penggunaan_ruangan == "perkuliahan"){
                $cekdobleKelas = RuangPerkuliahan::where('kelasperkuliahan_id',$request->idkelas)->first();
                if($cekdobleKelas != NULL && $cekdobleKelas->penggunaanruang == $request->penggunaanruang){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Kelas sudah ada diruangan lain']);
                }
            }elseif($cektype->penggunaan_ruangan == "PEPT"){
                $cekdobleKelas = RuangPerkuliahan::where('pept_id',$request->pept_id)->first();

                if($cekdobleKelas != NULL && $cekdobleKelas->penggunaanruang == $request->penggunaanruang){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'PEPT sudah ada diruangan lain']);
                }
            }

            $datasenin = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id',$request->ruang)->pluck('hari','waktu');

            $senin = "";
            $selasa = "";
            $rabu = "";
            $kamis = "";
            $jumat = "";
            $sabtu ="";
            foreach($datasenin as $b => $value){
                if($value == "senin"){
                    $senin .= $b;
                }else if($value == "selasa"){
                    $selasa .= $b;
                }else if($value == "rabu"){
                    $rabu .= $b;
                }else if($value == "kamis"){
                    $kamis .= $b;
                }else if($value == "jumat"){
                    $jumat .= $b;
                }else if($value == "sabtu"){
                    $sabtu.= $b;
                }
            }
            $senin = $this->multiexplode(array('[', ']', '"', '"', ','), $senin);
            $selasa = $this->multiexplode(array('[', ']', '"', '"', ','), $selasa);
            $rabu= $this->multiexplode(array('[', ']', '"', '"', ','), $rabu);
            $kamis = $this->multiexplode(array('[', ']', '"', '"', ','), $kamis);
            $jumat = $this->multiexplode(array('[', ']', '"', '"', ','), $jumat);
            $sabtu = $this->multiexplode(array('[', ']', '"', '"', ','), $sabtu);

            $hari = $request->hari;

            if($hari == 'senin'){
                if(in_array($request->jamawal,$senin)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'selasa'){
                if(in_array($request->jamawal,$selasa)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'rabu'){
                if(in_array($request->jamawal,$rabu)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'kamis'){
                if(in_array($request->jamawal,$kamis)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'jumat'){
                if(in_array($request->jamawal,$jumat)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'sabtu'){
                if(in_array($request->jamawal,$sabtu)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang)->with(['error' => 'Jam sudah dgunakan']);
                }
            }

            $semesteraktif = JenisSemester::where('active',1)->first();

            $saves = new RuangPerkuliahan();
            $saves->jenissemester_id = $request->jenissemester_id ?? $semesteraktif->id;
            $saves->kelasperkuliahan_id = $request->idkelas ?? NULL;
            $saves->penggunaanruang_id = $request->penggunaanruang;
            $saves->ruang_id = $request->ruang ?? 0;
            $saves->pept_id = $request->idpept ?? null;
            $saves->kode = $request->kode ?? NULL;
            $saves->hari = $request->hari ?? NULL;
            $saves->waktu =  $waktu;
            $saves->jam_awal = $request->jamawal;
            $saves->jam_akhir = $timeAkhir;
            $saves->tanggal_awal_masuk =  $tanggalmulai;
            $saves->tanggal_akhir_masuk =  $tanggalmulai;
            $saves->save();

            $id = $saves->id;

            $savejadwal = new JadwalKelas;
            $savejadwal->ruangperkuliahan_id = $id;
            $savejadwal->ruang_id = $request->ruang;
            $savejadwal->jenissemester_id = $request->jenissemester_id ?? $semesteraktif->id;
            $savejadwal->pertemuan_ke = $i+1;
            $savejadwal->tanggal_perkuliahan =  $tanggalmulai;
            $savejadwal->type = 'pept';
            $savejadwal->jam_masuk = $request->jamawal;
            $savejadwal->jam_keluar = $timeAkhir;
            $savejadwal->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

        }

        if($saves){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Success',
                    'data' => $saves
                ]
            );
        }else{
            return response()->json(
                [
                    'status' => false,
                    'message' => 'failed',
                    'data' => $exception->getMessage()
                ]
            );
        }


        // return response()->json($request->all());
    }

    public function jadwalKelas($id){
        // $data = JadwalKelas::where('ruangperkuliahan_id', $id)->with('ruangperkuliahan.kelasperkuliahan')
        // ->get('id');
        $data = DB::table('jadwal_kelas')
        ->where('jadwal_kelas.ruang_id', $id)
        ->leftJoin('ruang_perkuliahans', 'ruang_perkuliahans.id', '=', 'jadwal_kelas.ruangperkuliahan_id')
        ->leftJoin('kelas_perkuliahans', 'kelas_perkuliahans.id', '=', 'ruang_perkuliahans.kelasperkuliahan_id')
        ->select('jadwal_kelas.id as ids','tanggal_perkuliahan','jam_masuk','jam_keluar','kelas_perkuliahans.nama_kelas as namakelas','kelas_perkuliahans.kode as code','kelas_perkuliahans.color as colors')
        ->get();

        $datas = [];
        foreach ($data as $r) {
                $datas[] = array('id' => $r->ids,'title' => $r->namakelas.$r->code,'start'=>$r->tanggal_perkuliahan.'T'.$r->jam_masuk,'end'=>$r->tanggal_perkuliahan.'T'.$r->jam_keluar,'color'=>$r->colors);
        }

        return response()->json($datas);
    }

    public function getJadwalById($id){
        $data = JadwalKelas::with('ruangperkuliahan')->findOrFail($id);
        return response()->json($data);
    }

    public function deleteKelas(Request $request){
        DB::beginTransaction();
        try {
            $deleteRuangPerkuliahan = RuangPerkuliahan::where('id',$request->ruangperkuliahanid)->delete();
            $deletejadwal = JadwalKelas::where('ruang_id',$request->ruangid)->where('ruangperkuliahan_id',$request->ruangperkuliahanid)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($deleteRuangPerkuliahan) {
            //redirect dengan pesan sukses
            return redirect()->back()->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(["error" => "Data Gagal Dihapus!"]);
        }

    }

    public function updateCalendar(Request $request)
    {
        $tanggalmulai = Carbon::parse($request->tanggalawalmasuk)->format("Y-m-d H:i:s");
        $semesteraktif= JenisSemester::where('active',1)->first();
        DB::beginTransaction();
        try {
            $jadwalkelas = JadwalKelas::findOrFail($request->idkelas);

            $minute = 120;

            $get = substr($request->jamawal, 0,8);
            $timeAkhir = date('H:i:s', strtotime($get. ' +'.$minute.' minutes'));
            $open_time = strtotime($request->jamawal);

            $close_time = $timeAkhir;
            $output = "";
            for ($i = $open_time; $i < $close_time; $i+= 300) {
                $output .= date('H:i',$i)." ";
            }

            $ar = explode(" ",$output);
            $waktu = json_encode($ar);


            $jadwalkelas->ruangperkuliahan_id = $jadwalkelas->ruangperkuliahan_id;
            $jadwalkelas->ruang_id = $request->ruang;
            $jadwalkelas->pertemuan_ke = 1;
            $jadwalkelas->tanggal_perkuliahan = $tanggalmulai;
            $jadwalkelas->type = $jadwalkelas->type;
            $jadwalkelas->jenissemester_id = $jadwalkelas->jenissemester_id ?? $semesteraktif->id;
            $jadwalkelas->jam_masuk = $request->jamawal;
            $jadwalkelas->jam_keluar = $timeAkhir;
            $jadwalkelas->save();


            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

        }

        if($jadwalkelas){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Success',
                    'data' => $jadwalkelas
                ]
            );
        }else{
            return response()->json(
                [
                    'status' => false,
                    'message' => 'failed',
                    'data' => $exception->getMessage()
                ]
            );
        }

    }

}
