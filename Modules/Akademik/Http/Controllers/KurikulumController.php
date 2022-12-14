<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Kurikulum;
use App\Models\ProgramStudy;
use App\Models\MataKuliah;
use App\Models\JenisSemester;
use App\Models\KurikulumMatakuliah;
use App\Providers\NeoFeederProvider;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KurikulumController extends Controller
{

    use ValidatesRequests;

     function __construct()
    {
         $this->middleware("permission:kurikulum-view|kurikulum-create|kurikulum-edit|kurikulum-show|kurikulum-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:kurikulum-view", ["only" => ["index"]]);
         $this->middleware("permission:kurikulum-create", ["only" => ["create","store"]]);
         $this->middleware("permission:kurikulum-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:kurikulum-show", ["only" => ["show"]]);
         $this->middleware("permission:kurikulum-delete", ["only" => ["destroy"]]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows("kurikulum-show");
            $canUpdate = Gate::allows("kurikulum-edit");
            $canDelete = Gate::allows("kurikulum-delete");
            // $data = Kurikulum::with("Programstudy","Jenissemester")->get();
            $data = Kurikulum::has("Programstudy.jurusans")
                ->has("Jenissemester")
                ->with(["Programstudy.jurusans","Jenissemester"])->get();
            return DataTables::of($data)
                    ->addColumn('checkbox_action', function($data) {
                        return '<label><input type="checkbox" class="filled-in" name="ids[]" value="'. $data->id .'" /><span></span></label>';
                    })
                    ->addColumn('programstudy', function($data){
                        foreach($data->Programstudy->jurusans as $t) {
                            $var = $t->nama_jurusan;
                            return $data->Programstudy->jenjang->nama_jenjang ."-" . $var;
                        }
                    })

                    ->addColumn('masaberlaku', function($data){
                        foreach($data->Jenissemester->tahun_ajarans as $ta) {
                            $var_ta = $ta->tahun_ajaran;
                            return $var_ta ."-" . $data->Jenissemester->jenis_semester;;
                        }
                        // return $data->Jenissemester->Tahunajaran->tahun_ajaran .'-'. $data->Jenissemester->jenis_semester;
                    })


                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        $url = route('kurikulum.edit',$data->id);
                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if($data->is_neo_feeder_already_sync) {
                            $btn .= '<div class="btn-floating green darken-1 btn-small"><i class="material-icons">check</i></div>';
                        }else{
                            $btn .= '<div class="btn-floating orange darken-1 btn-small"><i class="material-icons">warning</i></div>';
                        }



                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="kurikulum/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;
                    })
                    ->rawColumns(['action', 'checkbox_action'])
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    "status" => false,
                    "message" => $e->getMessage()
                ], 400
            );
        }


    }

    public function index()
    {
        $canCreate = Gate::allows("kurikulum-create");
        // dd($datas);
        $name_page = "kurikulum";
        $title = "Kurikulum";
        $data = array(
            "page" => $name_page,
            "canCreate" => $canCreate,
            "title" => $title
        );
        return view("akademik::kurikulum.index")->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "kurikulum";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $jenissemester = JenisSemester::all();
        $title = "Substansi Kuliah";
        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,
            "jenissemester" => $jenissemester
        );
        return view("akademik::kurikulum.create")->with($data);
    }

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
                "nama_kurikulum" => "required",
                "programstudy_id" => "required",
                "jumlah_bobot_mata_kuliah_pilihan" => 'required',
                "masa_berlaku" => 'required',
                "jumlah_bobot_mata_kuliah_wajib" => 'required'
            ]);


            $save = new Kurikulum();
            $save->nama_kurikulum = $request->nama_kurikulum;
            $save->programstudy_id = $request->programstudy_id;
            $save->jumlah_bobot_mata_kuliah_pilihan = $request->jumlah_bobot_mata_kuliah_pilihan;
            $save->masa_berlaku = $request->masa_berlaku;
            $save->jumlah_sks = $request->jumlah_bobot_mata_kuliah_pilihan + $request->jumlah_bobot_mata_kuliah_wajib;
            $save->jumlah_bobot_mata_kuliah_wajib = $request->jumlah_bobot_mata_kuliah_wajib;
            $save->save();


            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("kurikulum.index")->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("kurikulum.index")->with(["error" => "Data Gagal Disimpan!"]);
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view("akademik::show");
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $jenissemester = JenisSemester::all();
        $name_page = "kurikulum";
        $title = "Kurikulum";
        $data = array(
            "page" => $name_page,
            "kurikulum" => $kurikulum,
            "title" => $title,
            "programstudy" => $programstudy,
            "jenissemester" => $jenissemester

        );
        return view("akademik::kurikulum.edit")->with($data);
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
                "nama_kurikulum" => "required",
                "programstudy_id" => "required",
                "jumlah_bobot_mata_kuliah_pilihan" => 'required',
                "masa_berlaku" => 'required',

                "jumlah_bobot_mata_kuliah_wajib" => 'required'
            ]);


            $save = Kurikulum::findOrFail($id);
            $save->nama_kurikulum = $request->nama_kurikulum;
            $save->programstudy_id = $request->programstudy_id;
            $save->jumlah_bobot_mata_kuliah_pilihan = $request->jumlah_bobot_mata_kuliah_pilihan;
            $save->masa_berlaku = $request->masa_berlaku;
            $save->jumlah_sks = $request->jumlah_bobot_mata_kuliah_pilihan + $request->jumlah_bobot_mata_kuliah_wajib;
            $save->jumlah_bobot_mata_kuliah_wajib = $request->jumlah_bobot_mata_kuliah_wajib;
            $save->is_neo_feeder_already_sync = false;
            $save->save();


            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($save) {
                //redirect dengan pesan sukses
                return redirect()->route("kurikulum.index")->with(["success" => "Data Berhasil Diubah!"]);
            } else {
                //redirect dengan pesan error
                return redirect()->route("kurikulum.index")->with(["error" => "Data Gagal Diubah!"]);
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
           $data =  Kurikulum::find($id);

           if(!$data) {
            throw new ModelNotFoundException("Already deleted");
           }


           $data->neo_feeder_id = null;
           $data->is_neo_feeder_already_sync = false;
           $data->save();
           $delete =  Kurikulum::find($id);
           $delete->delete();
           DB::commit();
           if($data->neo_feeder_id) {
            $neoFeeder = new NeoFeederProvider();
            $neoFeeder->sendRequestToNewFeeder('DeleteKurikulum', [
                'key' => [
                    'id_kurikulum' => $data->neo_feeder_id
                ]
            ]);
           }



        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        } catch (Exception $ex) {
            return redirect()->route("kurikulum.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("kurikulum.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("kurikulum.index")->with(["error" => "Data Gagal Dihapus!"]);
        }

    }

    // kurikulum matakuliah
    public function dataKurikulumMatakuliah($id)
    {
        try {
            // $canShow = Gate::allows("kurikulum-show");
            // $canUpdate = Gate::allows("kurikulum-edit");
            $canDelete = Gate::allows("kurikulum-delete");
            $data = KurikulumMatakuliah::with('matakuliah')->where('kurikulum_id',$id)->get();
            return DataTables::of($data)
                    ->addColumn("pilihan", function($data){
                       return '<input type="hidden" class="center id" value="'.$data->id.'"><input type="number" class ="center  semester" max="8" min="1" value="'.$data->semester.'" onchange="myFunction(this.value)">';
                    })

                    ->addColumn('checkbox', function($data){

                        if($data->wajib == 'y'){
                            return ' <label>
                            <input type="checkbox" class="wajib"  value="'.$data->wajib.'" onchange="myChecked(this.value)" checked/>
                            <span></span>
                          </label>';
                        }else{
                            return '  <label>
                            <input type="checkbox" class="wajib" value="'.$data->wajib.'" onchange="myChecked(this.value)"/>
                            <span></span>
                          </label>';
                        }
                    })


                    ->addColumn("action", function ($data) use ( $canDelete) {

                        $btn = "";



                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }



                        return $btn;
                    })
                    ->rawColumns(['action', 'pilihan','checkbox'])
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

    public function dataKurikulumMatakuliahBelumTerdaftar($id)
    {
        try {
            // $canShow = Gate::allows("kurikulum-show");
            // $canUpdate = Gate::allows("kurikulum-edit");
            // $canDelete = Gate::allows("kurikulum-delete");
            $data = Matakuliah::with('KurikulumMatakuliah')->get();
            return DataTables::of($data)
                    ->addColumn("pilihan", function($data){
                       return '<input type="hidden" name="idmatakuliah" value="'.$data->id.'"><input type="number" name="semesters" class="center semesters" id="datasemester" max="8" min="1" >';
                    })

                    ->addColumn('checkbox', function($data){
                        return '  <label>
                        <input type="checkbox" value="y" name="wajibs" id="wajibs" class="wajibs" />
                        <span></span>
                      </label>';
                    })

                    ->addColumn("action", function ($data)  {

                            return'<button class="btn-floating green darken-1 btn-small btn-add " onClick="add()"  id="add" type="button"><i class="material-icons">add</i></button>';

                    })
                    ->rawColumns(['action', 'pilihan','checkbox'])
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

    public function updateSemester(Request $request)
    {

        DB::beginTransaction();
        try {
            $update = KurikulumMatakuliah::where('id',$request->id)->update(['semester'=>$request->semester]);
        DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function tambahSemester(Request $request)
    {

            $tambah = new KurikulumMatakuliah();
            $tambah->matakuliah_id = $request->idmatakuliah;
            $tambah->kurikulum_id = $request->idkurikulum;
            $tambah->semester = $request->semester;
            $tambah->wajib = $request->wajib;
            $tambah->save();

            return $tambah;

    }

    public function updateWajib(Request $request)
    {

        DB::beginTransaction();
        try {
            if($request->wajib == "y"){
                $value = "n";
            }else{
                $value = "y";
            }
            $update = KurikulumMatakuliah::where('id',$request->id)->update(['wajib'=>$value]);
        DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function  deleteMatakuliahKurikulum($id){
        DB::beginTransaction();
        try {
           $delete =  KurikulumMatakuliah::find($id)->delete();
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

    public function insertOrUpdateKurikulumInNeoFeeder(Request $request) {
        try{


            $kurikulums = Kurikulum::has('Programstudy')
                                    ->whereIn('id', $request->ids)
                                    ->with('Programstudy')
                                    ->get();
            $jenisSemester = JenisSemester::query()
                                ->has('Tahunajaran')
                                ->with('Tahunajaran')
                                ->where('active', 1)
                                ->first();
            $actionNeoFeederName = 'InsertKurikulum';
            if(!$jenisSemester) {
                $actionNeoFeederName = 'UpdateKurikulum';
                throw new Exception("Tidak ada semester yang aktif");
            }

            $idSemesterCode = explode('/', $jenisSemester->Tahunajaran->tahun_ajaran)[0]. ($jenisSemester->jenis_semester == 'ganjil' ? 1 : 2);
            $recordDataNewFeeder = [];
            foreach($kurikulums as $kurikulum) {

                if($kurikulum->neo_feeder_id) {
                    $actionNeoFeederName = 'UpdateKurikulum';
                    $recordDataNewFeeder['key'] = [
                        'id_kurikulum' => $kurikulum->neo_feeder_id
                    ];
                }
                $recordDataNewFeeder['record'] = [
                    'nama_kurikulum' => $kurikulum->nama_kurikulum,
                    'id_prodi' => $kurikulum->ProgramStudy->neo_feeder_id,
                    'id_semester' => (string) $idSemesterCode,
                    'jumlah_sks_lulus' => (string) $kurikulum->jumlah_sks,
                    'jumlah_sks_wajib' => (string) $kurikulum->jumlah_bobot_mata_kuliah_wajib,
                    'jumlah_sks_pilihan' => (string) $kurikulum->jumlah_bobot_mata_kuliah_pilihan
                ];
                $neoFeeder = new NeoFeederProvider();
                $neoFeeder = $neoFeeder->sendRequestToNewFeeder($actionNeoFeederName, $recordDataNewFeeder);
                DB::beginTransaction();
                $kurikulum->neo_feeder_id = $neoFeeder['id_kurikulum'];
                $kurikulum->is_neo_feeder_already_sync = true;
                $kurikulum->save();
                DB::commit();
            }

            return response()->json([
                'status' => true,
                'message' => 'success'
            ]);

        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
