<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\JenisSemester;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\KelasPerkuliahan;
use App\Models\PenggunaanRuangan;
use App\Models\PeptBatch;
use App\Models\RuangPerkuliahan;
use App\Models\RuangGedung;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;


class RuangPerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware("permission:ruangperkuliahan-view|ruangperkuliahan-create|ruangperkuliahan-edit|ruangperkuliahan-show|ruangperkuliahan-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:ruangperkuliahan-view", ["only" => ["index"]]);
         $this->middleware("permission:ruangperkuliahan-create", ["only" => ["create","store"]]);
         $this->middleware("permission:ruangperkuliahan-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:ruangperkuliahan-show", ["only" => ["show"]]);
         $this->middleware("permission:ruangperkuliahan-delete", ["only" => ["destroy"]]);
    }


    private function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $lauch = explode($delimiters[0], $ready);

        return $lauch;
    }

    use ValidatesRequests;

    public function data()
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("ruangperkuliahan-edit");
            $canDelete = Gate::allows("ruangperkuliahan-delete");
            $data = RuangGedung::with('Perkuliahan','listkampus','Uts','Uas')->withCount(['Perkuliahan','Uts','Uas'])->get();
            return DataTables::of($data)
            ->addColumn('kampus',function($data){
                return $data->ListKampus->cabang_kampus;
            })
            ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="ruangperkuliahan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

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
        $canCreate = Gate::allows('ruangperkuliahan-create');
        $name_page = "ruangperkuliahan";
        $title = "Management Ruangan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::ruangperkuliahan.index')->with($data);
    }


    public function create()
    {

        $datasenin = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id', 0)->pluck('hari','waktu');

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

        $kelasperkuliahan = KelasPerkuliahan::with('Matakuliah')->get();
        $penggunaanruang = PenggunaanRuangan::all();
        $open_time = strtotime("07:00");
        $close_time = strtotime("21:00");
        $name_page = "ruang perkuliahan";
        $title = "ruang perkuliahan";
        $data = array(
            'page' => $name_page,
            "title" => $title,
            "open_time" => $open_time,
            "close_time" => $close_time,
            "kelasperkuliahan" => $kelasperkuliahan,
            "penggunaanruang" => $penggunaanruang,
            "senin" =>$senin,
            "selasa" =>$selasa,
            "rabu" => $rabu,
            "kamis" => $kamis,
            "jumat" => $jumat,
            "sabtu" => $sabtu

        );
        return view('akademik::ruangperkuliahan.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    // public function create()
    // {
    //     return view('akademik::create');
    // }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                // 'kelasperkuliahan_id' => 'required',
                'penggunaanruang_id' => 'required',
            ]);

            $open_time = strtotime($request->jam_mulai);

            $close_time = strtotime($request->jam_akhir);
            $output = "";
            for ($i = $open_time; $i < $close_time; $i+= 300) {
                $output .= date('H:i',$i)." ";
            }

            $ar = explode(" ",$output);
            $waktu = json_encode($ar);

            $cektype = PenggunaanRuangan::findOrFail($request->penggunaanruang_id);
            if($cektype->penggunaan_ruangan == "perkuliahan"){
                $cekdobleKelas = RuangPerkuliahan::where('kelasperkuliahan_id',$request->kelasperkuliahan_id)->first();


                if($cekdobleKelas != NULL && $cekdobleKelas->penggunaanruang_id == $request->penggunaanruang_id){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Kelas sudah ada diruangan lain']);
                }
            }elseif($cektype->penggunaan_ruangan == "PEPT"){
                $cekdobleKelas = RuangPerkuliahan::where('pept_id',$request->pept_id)->first();

                if($cekdobleKelas != NULL && $cekdobleKelas->penggunaanruang_id == $request->penggunaanruang_id){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'PEPT sudah ada diruangan lain']);
                }
            }



            $datasenin = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id',$request->ruang_id)->pluck('hari','waktu');

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
                if(in_array($request->jam_mulai,$senin)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'selasa'){
                if(in_array($request->jam_mulai,$selasa)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'rabu'){
                if(in_array($request->jam_mulai,$rabu)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'kamis'){
                if(in_array($request->jam_mulai,$kamis)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'jumat'){
                if(in_array($request->jam_mulai,$jumat)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Jam sudah dgunakan']);
                }
            }elseif($hari == 'sabtu'){
                if(in_array($request->jam_mulai,$sabtu)){
                    return redirect()->route('ruangperkuliahan.create',$request->ruang_id)->with(['error' => 'Jam sudah dgunakan']);
                }
            }

            $semesteraktif = JenisSemester::where('active',1)->first();

            $save = new RuangPerkuliahan();
            $save->jenissemester_id = $request->jenissemester_id ?? $semesteraktif->id;
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id ?? NULL;
            $save->penggunaanruang_id = $request->penggunaanruang_id;
            $save->ruang_id = $request->ruang_id ?? 0;
            $save->pept_id = $request->pept_id ?? null;
            $save->kode = $request->kode ?? NULL;
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->hari = $request->hari ?? NULL;
            $save->waktu = $waktu ?? null;
            $save->jam_awal =$request->jam_mulai;
            $save->jam_akhir = $request->jam_akhir ?? null;
            $save->tanggal_awal_masuk = $request->tanggal_awal_masuk;
            $save->tanggal_akhir_masuk = $request->tanggal_akhir_masuk ?? NULL;
            $save->save();

            $id = $save->id;

            if($cektype->penggunaan_ruangan == "perkuliahan"){
                $this->generateTanggal($request, $id);
            }

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('ruangperkuliahan.show',$request->ruang_id)->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('ruangperkuliahan.show',$request->ruang_id)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        $canCreate = Gate::allows('ruangperkuliahan-create');
        $name_page = "ruangperkuliahan";
        $title = "Management Ruangan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title,
            "id" => $id
        );
        return view('akademik::ruangperkuliahan.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        return view('akademik::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'kelasperkuliahan_id' => 'required',
                'penggunaanruang_id' => 'required',
            ]);


            $open_time = strtotime($request->jam_mulai);
            $close_time = strtotime($request->jam_akhir);
            $output = "";
            for ($i = $open_time; $i < $close_time; $i+= 300) {
                $output .= date('H:i',$i)." ";
            }

            $ar = explode(" ",$output);
            $waktu = json_encode($ar);


            $save = RuangPerkuliahan::findOrFail($id);
            $save->jenissemester_id = $request->jenissemester_id ?? NULL;
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->penggunaanruang_id = $request->penggunaanruang_id;
            $save->ruang_id = $request->ruang_id ?? 0;
            $save->kode = $request->kode;
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->hari = $request->hari;
            $save->waktu = $waktu;
            $save->jam_awal =$request->jam_mulai;
            $save->jam_akhir = $request->jam_akhir;
            $save->tanggal_awal_masuk = $request->tanggal_awal_masuk;
            $save->save();

            JadwalKelas::where('ruangperkuliahan_id', $id)->delete();

            $this->generateTanggal($request, $id);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('ruangperkuliahan.show',$request->ruang_id)->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('ruangperkuliahan.show',$request->ruang_id)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        DB::beginTransaction();
        try {
           $delete =  RuangPerkuliahan::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->back()->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(["error" => "Data Gagal Dihapus!"]);
        }
    }

    public function dataKelas($id)
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("kelasperkuliahan-edit");
            $canDelete = Gate::allows("kelasperkuliahan-delete");
            $semester = JenisSemester::where("active",1)->latest()->first();
            $data = RuangPerkuliahan::with('kelasPerkuliahan','kelasPerkuliahan.programstudy','kelasPerkuliahan.matakuliah','PenggunaanRuangs')->where('ruang_id',$id)->where('jenissemester_id', $semester->id)->orWhere("jenissemester_id",NULL)->get();
            return DataTables::of($data)
                    ->addColumn('namakelas', function($data){
                        if($data->kelasperkuliahan_id != null){
                            return $data->kelasperkuliahan->nama_kelas.$data->kelasperkuliahan->kode;
                        }else{
                            return $data->pept->nama_batch;
                        }

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
                        return Carbon::createFromFormat('H:i:s',$data->jam_awal)->format('H:i');
                    })

                    ->addColumn('jamakhir',function($data){
                        return Carbon::createFromFormat('H:i:s',$data->jam_akhir)->format('H:i');
                    })

                    ->addColumn('tanggal',function($data){
                        if($data->tanggal_akhir_masuk){
                            return Carbon::parse($data->tanggal_awal_masuk)->isoFormat('D MMMM Y') .'-'. Carbon::parse($data->tanggal_akhir_masuk)->isoFormat('D MMMM Y');
                        }else{
                            return Carbon::parse($data->tanggal_awal_masuk)->isoFormat('D MMMM Y');
                        }

                    })



                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $url = route('ruangperkuliahan.edit',$data->id);
                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

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

    public function createKelasByRuangan($id){

        $semesteraktif = JenisSemester::with('TahunAjaran')->where('active',1)->first();
        $semester = JenisSemester::with('TahunAjaran')->get();
        $data = RuangPerkuliahan::with('kelasPerkuliahan')->where('jenissemester_id', $semesteraktif->id)->where('ruang_id',$id)->pluck('hari','waktu');

        $senin = "";
        $selasa = "";
        $rabu = "";
        $kamis = "";
        $jumat = "";
        $sabtu ="";

        foreach($data as $b => $value){
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

        // $dataall = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id',$id)->get();

        $peptbatch = PeptBatch::where('jenissemester_id', $semesteraktif->id)->get();
        $kelasperkuliahan = KelasPerkuliahan::with('Matakuliah')->get();
        $penggunaanruang = PenggunaanRuangan::all();
        $open_time = strtotime("07:00");
        $close_time = strtotime("21:00");
        $name_page = "ruang perkuliahan";
        $title = "ruang perkuliahan";
        $data = array(
            'page' => $name_page,
            "title" => $title,
            "open_time" => $open_time,
            "close_time" => $close_time,
            "kelasperkuliahan" => $kelasperkuliahan,
            "penggunaanruang" => $penggunaanruang,
            "senin" =>$senin,
            "selasa" =>$selasa,
            "rabu" => $rabu,
            "kamis" => $kamis,
            "jumat" => $jumat,
            "sabtu" => $sabtu,
            "id" => $id,
            "semesteraktif"=> $semesteraktif,
            "semester" => $semester,
            "peptbatch" => $peptbatch

        );


        return view('akademik::ruangperkuliahan.create')->with($data);
    }

    public function editkelasByRuangan($id)
    {
        $semesteraktif = JenisSemester::with('TahunAjaran')->where('active',1)->first();
        $semester = JenisSemester::with('TahunAjaran')->get();
        $old = RuangPerkuliahan::with('kelasPerkuliahan')->findOrFail($id);
        $data = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id',$old->ruang_id)->pluck('hari','waktu');

        $senin = "";
        $selasa = "";
        $rabu = "";
        $kamis = "";
        $jumat = "";
        $sabtu ="";

        foreach($data as $b => $value){
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

        // $dataall = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id',$id)->get();

        $kelasperkuliahan = KelasPerkuliahan::with('Matakuliah')->get();
        $penggunaanruang = PenggunaanRuangan::all();
        $open_time = strtotime("07:00");
        $close_time = strtotime("21:00");
        $name_page = "ruang perkuliahan";
        $title = "ruang perkuliahan";
        $data = array(
            'page' => $name_page,
            "title" => $title,
            "open_time" => $open_time,
            "close_time" => $close_time,
            "kelasperkuliahan" => $kelasperkuliahan,
            "penggunaanruang" => $penggunaanruang,
            "senin" =>$senin,
            "selasa" =>$selasa,
            "rabu" => $rabu,
            "kamis" => $kamis,
            "jumat" => $jumat,
            "sabtu" => $sabtu,
            'old' => $old,
            "semesteraktif"=> $semesteraktif,
            "semester" => $semester

        );
        return view('akademik::ruangperkuliahan.edit')->with($data);
    }

    public function generateTanggal(Request $request, $timeAkhir,$id){

        DB::beginTransaction();
        try {
            $semesteraktif=JenisSemester::where('active',1)->latest()->first();
            $tanggal = Carbon::parse($request->tanggalawalmasuk)->isoFormat("YYYY-MM-DD");
            $i = 1;
            for($i = 0; $i <= 15; $i++){
                    if($i+1 == 8){
                        $type = "uts";
                    }elseif($i+1 == 16){
                        $type = "uas";
                    }else{
                        $type = "perkuliahan";
                    }

                        $save = new JadwalKelas;
                        $save->ruangperkuliahan_id = $id;
                        $save->ruang_id = $request->ruang;
                        $save->jenissemester_id = $request->jenissemester_id ?? $semesteraktif->id;
                        $save->pertemuan_ke = $i+1;
                        $save->tanggal_perkuliahan = Carbon::parse($tanggal)->addWeek($i);
                        $save->type = $type;
                        $save->jam_masuk = $request->jamawal;
                        $save->jam_keluar = $timeAkhir;
                        $save->save();
            }



            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
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
            'pept' => false
        );
        return view('akademik::ruangperkuliahan.calendar')->with($data);
    }

    public function insertCalendar(Request $request){
        $tanggalmulai = Carbon::parse($request->tanggalawalmasuk)->format("Y-m-d H:i:s");
        $semesteraktif= JenisSemester::where('active',1)->first();


        DB::beginTransaction();
        try {

            $ceksks = KelasPerkuliahan::with('matakuliah')->findOrFail($request->idkelas);
            $minute = number_format($ceksks->Matakuliah->bobot_mata_kuliah) * 50;


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

            $save = new RuangPerkuliahan();
            $save->jenissemester_id = $request->jenissemester_id ?? $semesteraktif->id;
            $save->kelasperkuliahan_id = $request->idkelas ?? NULL;
            $save->penggunaanruang_id = $request->penggunaanruang;
            $save->ruang_id = $request->ruang ?? 0;
            $save->pept_id = $request->pept_id ?? null;
            $save->kode = $request->kode ?? NULL;
            $save->hari = $request->hari ?? NULL;
            $save->waktu =  $waktu;
            $save->jam_awal =$request->jamawal;
            $save->jam_akhir = $timeAkhir;
            $save->tanggal_awal_masuk =  $tanggalmulai;
            $save->tanggal_akhir_masuk = Carbon::parse($tanggalmulai)->addWeek(15);
            $save->save();

            $id = $save->id;

            if($cektype->penggunaan_ruangan == "perkuliahan"){
                $this->generateTanggal($request,$timeAkhir, $id);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

        }

        if($save){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Success',
                    'data' => $save
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
        ->leftJoin('pept_batches', 'pept_batches.id', '=', 'ruang_perkuliahans.pept_id')
        ->select('jadwal_kelas.id as ids','tanggal_perkuliahan','jam_masuk','jam_keluar','kelas_perkuliahans.nama_kelas as namakelas','kelas_perkuliahans.kode as code','pept_batches.nama_batch as namabatch','kelas_perkuliahans.color as colors')
        ->get();

        $datas = [];
        foreach ($data as $r) {
                $datas[] = array(
                    'id' => $r->ids,
                    'title' => $r->namakelas ? $r->namakelas.$r->code : $r->namabatch,
                    'start'=>$r->tanggal_perkuliahan.'T'.$r->jam_masuk,
                    'end'=>$r->tanggal_perkuliahan.'T'.$r->jam_keluar,
                    'color'=>$r->colors);
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
            $ruangPerkuliahan = RuangPerkuliahan::findOrFail($jadwalkelas->ruangperkuliahan_id);
            $ceksks = KelasPerkuliahan::with('matakuliah')->findOrFail($ruangPerkuliahan->kelasperkuliahan_id);
            $minute = number_format($ceksks->Matakuliah->bobot_mata_kuliah) * 50;

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
            $jadwalkelas->pertemuan_ke = $jadwalkelas->pertemuan_ke;
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
