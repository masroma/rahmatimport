<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProgramStudy;
use App\Models\MataKuliah;
use App\Models\JenisSemester;
use App\Models\KelasPerkuliahan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KelasKuliahController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;


    function __construct()
    {
         $this->middleware("permission:kelasperkuliahan-view|kelasperkuliahan-create|kelasperkuliahan-edit|kelasperkuliahan-show|kelasperkuliahan-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:kelasperkuliahan-view", ["only" => ["index"]]);
         $this->middleware("permission:kelasperkuliahan-create", ["only" => ["create","store"]]);
         $this->middleware("permission:kelasperkuliahan-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:kelasperkuliahan-show", ["only" => ["show"]]);
         $this->middleware("permission:kelasperkuliahan-delete", ["only" => ["destroy"]]);
    }

    public function data()
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("kelasperkuliahan-edit");
            $canDelete = Gate::allows("kelasperkuliahan-delete");
            $data = KelasPerkuliahan::with("Programstudy","Matakuliah")->get();
            return DataTables::of($data)
                    ->addColumn("programstudy", function($data){
                        return $data->Programstudy->jurusan->nama_jurusan.'-'.$data->Programstudy->jenjang->nama_jenjang;
                    })

                    ->addColumn("matalkuliah", function($data){
                            return $data->Matakuliah->nama_matakuliah;
                    })

                    ->addColumn("kodematalkuliah", function($data){
                        return $data->Matakuliah->kode_matakuliah;
                })

                    ->addColumn('semester', function($data){
                        return $data->Jenissemester->Tahunajaran->tahun_ajaran .'-'. $data->Jenissemester->jenis_semester;
                    })



                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kelasperkuliahan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;
                    })
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
        $canCreate = Gate::allows("kelasperkuliahan-create");
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $data = array(
            "page" => $name_page,
            "canCreate" => $canCreate,
            "title" => $title
        );
        return view("akademik::kelasperkuliahan.index")->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $matakuliah = MataKuliah::all();
        $jenissemester = JenisSemester::all();
        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,
            "matakuliah"=>$matakuliah,
            "jenissemester" => $jenissemester

        );

        return view("akademik::kelasperkuliahan.create")->with($data);
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
                "programstudy_id" => 'required',
                "semester_id" => 'required',
                "matakuliah_id" => 'required',
                "nama_kelas" => 'required'

            ]);

            $save = new KelasPerkuliahan();
            $save->programstudy_id = $request->programstudy_id;
            $save->semester_id = $request->semester_id;
            $save->matakuliah_id = $request->matakuliah_id;
            $save->nama_kelas = $request->nama_kelas;
            $save->lingkup = $request->lingkup;
            $save->mode_kuliah = $request->mode_kuliah;
            $save->tanggal_mulai_kuliah = $request->tanggal_mulai_kuliah;
            $save->tanggal_akhir_kuliah = $request->tanggal_akhir_kuliah;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("kelasperkuliahan.index")->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("kelasperkuliahan.index")->with(["error" => "Data Gagal Disimpan!"]);
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
        $kelasperkuliahan = KelasPerkuliahan::findOrFail($id);
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $matakuliah = MataKuliah::all();
        $jenissemester = JenisSemester::all();
        $data = array(
            "page" => $name_page,
            "matakuliah" => $matakuliah,
            "kelasperkuliahan" => $kelasperkuliahan,
            "title" => $title,
            "programstudy" => $programstudy,
            "jenissemester" => $jenissemester

        );
        return view("akademik::kelasperkuliahan.edit")->with($data);
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
                "programstudy_id" => 'required',
                "semester_id" => 'required',
                "matakuliah_id" => 'required',
                "nama_kelas" => 'required'

            ]);

            $save = KelasPerkuliahan::findOrFail($id);
            $save->programstudy_id = $request->programstudy_id;
            $save->semester_id = $request->semester_id;
            $save->matakuliah_id = $request->matakuliah_id;
            $save->nama_kelas = $request->nama_kelas;
            $save->lingkup = $request->lingkup;
            $save->mode_kuliah = $request->mode_kuliah;
            $save->tanggal_mulai_kuliah = $request->tanggal_mulai_kuliah;
            $save->tanggal_akhir_kuliah = $request->tanggal_akhir_kuliah;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($save) {
                //redirect dengan pesan sukses
                return redirect()->route("kelasperkuliahan.index")->with(["success" => "Data Berhasil Diubah!"]);
            } else {
                //redirect dengan pesan error
                return redirect()->route("kelasperkuliahan.index")->with(["error" => "Data Gagal Diubah!"]);
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
           $delete =  KelasPerkuliahan::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("kelasperkuliahan.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("kelasperkuliahan.index")->with(["error" => "Data Gagal Dihapus!"]);
        }

    }
}
