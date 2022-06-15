<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\MataKuliah;
use App\Models\ProgramStudy;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MataKuliahController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
   use ValidatesRequests;


    // function __construct()
    // {
    //      $this->middleware("permission:matakuliah-view|matakuliah-create|matakuliah-edit|matakuliah-show|matakuliah-delete", ["only" => ["index","store"]]);
    //      $this->middleware("permission:matakuliah-view", ["only" => ["index"]]);
    //      $this->middleware("permission:matakuliah-create", ["only" => ["create","store"]]);
    //      $this->middleware("permission:matakuliah-edit", ["only" => ["edit","update"]]);
    //      $this->middleware("permission:matakuliah-show", ["only" => ["show"]]);
    //      $this->middleware("permission:matakuliah-delete", ["only" => ["destroy"]]);

    // }

    public function data()
    {
        try {
            $canShow = Gate::allows("matakuliah-show");
            $canUpdate = Gate::allows("matakuliah-edit");
            $canDelete = Gate::allows("matakuliah-delete");
            $data = MataKuliah::with("ProgramStudy")->get();
            return DataTables::of($data)
                    ->addColumn("tanggalmulai", function($data){
                        return Carbon::parse($data->tanggal_mulai_efektif)->isoFormat("D MMMM Y");
                    })

                    ->addColumn("tangalakhir", function($data){
                        return Carbon::parse($data->tanggal_akhir_efektif)->isoFormat("D MMMM Y");
                    })

                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="matakuliah/" .$data->id. "/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm(".$data->id.")"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/" .$data->id. "/show"><i class="material-icons">remove_red_eye</i></a>';
                        }

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
        $canCreate = Gate::allows("matakuliah-create");
        $name_page = "matakuliah";
        $title = "Mata Kuliah";
        $data = array(
            "page" => $name_page,
            "canCreate" => $canCreate,
            "title" => $title
        );
        return view("akademik::matakuliah.index")->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "matakuliah";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $form =
        $title = "Mata Kuliah";
        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,

        );

        return view("akademik::matakuliah.create")->with($data);
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
                "kode_matakuliah" => "required",
                "nama_matakuliah" => "required",
                "programstudy_id" => "required",
                "jenis_mata_kuliah" => "required",
                "bobot_mata_kuliah" => "required",
                "bobot_tatap_muka" => "required",
                "bobot_pratikum" => "required",
                "bobot_praktek_lapanagn" => "required",
                "bobot_simulasi" => "required",
                "metode_pembelajaran" => "required",
                "tanggal_mulai_efektif" => "required",
                "tanggal_akhir_efektif" => "reqiured"
            ]);



            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("matakuliah.index")->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("matakuliah.index")->with(["error" => "Data Gagal Disimpan!"]);
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
        $matakuliah = MataKuliah::findOrFail($id);
        $name_page = "matakuliah";
        $title = "Program study";
        $data = array(
            "page" => $name_page,
            "matakuliah" => $matakuliah,
            "title" => $title,

        );
        return view("akademik::matakuliah.edit")->with($data);
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
            // $validated = $this->validate($request, [
            //     "kode_matakuliah" => "required",
            //     "nama_matakuliah" => "required",
            //     "programstudy_id" => "required",
            //     "jenis_mata_kuliah" => "required",
            //     "bobot_mata_kuliah" => "required",
            //     "bobot_tatap_muka" => "required",
            //     "bobot_pratikum" => "required",
            //     "bobot_praktek_lapanagn" => "required",
            //     "bobot_simulasi" => "required",
            //     "metode_pembelajaran" => "required",
            //     "tanggal_mulai_efektif" => "required",
            //     "tanggal_akhir_efektif" => "reqiured"
            // ]);

            // $update = MataKuliah::find($id)->update($validated);
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route("matakuliah.index")->with(["success" => "Data Berhasil Diubah!"]);
            } else {
                //redirect dengan pesan error
                return redirect()->route("matakuliah.index")->with(["error" => "Data Gagal Diubah!"]);
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
           $delete =  MataKuliah::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($update) {
            //redirect dengan pesan sukses
            return redirect()->route("matakuliah.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("matakuliah.index")->with(["error" => "Data Gagal Dihapus!"]);
        }

    }
}
