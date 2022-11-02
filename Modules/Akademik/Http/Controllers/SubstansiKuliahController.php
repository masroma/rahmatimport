<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProgramStudy;
use App\Models\SubstansiKuliah;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SubstansiKuliahController extends Controller
{

    use ValidatesRequests;

     function __construct()
    {
         $this->middleware("permission:substansikuliah-view|substansikuliah-create|substansikuliah-edit|substansikuliah-show|substansikuliah-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:substansikuliah-view", ["only" => ["index"]]);
         $this->middleware("permission:substansikuliah-create", ["only" => ["create","store"]]);
         $this->middleware("permission:substansikuliah-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:substansikuliah-show", ["only" => ["show"]]);
         $this->middleware("permission:substansikuliah-delete", ["only" => ["destroy"]]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows("substansikuliah-show");
            $canUpdate = Gate::allows("substansikuliah-edit");
            $canDelete = Gate::allows("substansikuliah-delete");
            $data = SubstansiKuliah::with("ProgramStudy")->get();
            return DataTables::of($data)
            ->addColumn("programstudy", function($data){
                return $data->ProgramStudy->jurusan->nama_jurusan.'-'.$data->Programstudy->jenjang->nama_jenjang;
            })

                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="substansikuliah/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="substansikuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows("substansikuliah-create");
        $name_page = "substansikuliah";
        $title = "Substansi Kuliah";
        $data = array(
            "page" => $name_page,
            "canCreate" => $canCreate,
            "title" => $title
        );
        return view("akademik::substansikuliah.index")->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "substansikuliah";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $title = "Substansi Kuliah";
        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,

        );

        return view("akademik::substansikuliah.create")->with($data);
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
                "nama_substansi" => "required",
                "programstudy_id" => "required",
                // "bobot_mata_kuliah" => 'required',
                // "bobot_tatap_muka" => 'required',
                // "bobot_pratikum" => 'required',
                // "bobot_praktek_lapangan" => 'required',
                // "bobot_simulasi" => 'required'
            ]);


            $save = new SubstansiKuliah();
            $save->nama_sunstansi = $request->nama_substansi;
            $save->programstudy_id = $request->programstudy_id;
            $save->bobot_mata_kuliah = $request->bobot_mata_kuliah ?? 0;
            $save->bobot_tatap_muka = $request->bobot_tatap_muka ?? 0;
            $save->bobot_pratikum = $request->bobot_pratikum ?? 0;
            $save->bobot_praktek_lapangan = $request->bobot_praktek_lapangan ?? 0;
            $save->bobot_simulasi = $request->bobot_simulasi ?? 0;
            $save->save();


            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("substansikuliah.index")->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("substansikuliah.index")->with(["error" => "Data Gagal Disimpan!"]);
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $substansikuliah = SubstansiKuliah::with('ProgramStudy.jurusans','ProgramStudy.jenjangs')->where('id',$id)->first();
        // dd($substansikuliah);
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();

        $name_page = "substansikuliah";
        $title = "Substansi Kuliah";
        $data = array(
            "page" => $name_page,
            "substansikuliah" => $substansikuliah,
            "title" => $title,
            "programstudy" => $programstudy,
        );
        return view("akademik::substansikuliah.show")->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $substansikuliah = SubstansiKuliah::with('ProgramStudy.jurusans','ProgramStudy.jenjangs')->where('id',$id)->first();
        // dd($substansikuliah);
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();

        $name_page = "substansikuliah";
        $title = "Substansi Kuliah";
        $data = array(
            "page" => $name_page,
            "substansikuliah" => $substansikuliah,
            "title" => $title,
            "programstudy" => $programstudy,
        );
        return view("akademik::substansikuliah.edit")->with($data);
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
                "nama_substansi" => "required",
                "programstudy_id" => "required",
                // "bobot_mata_kuliah" => 'required',
                // "bobot_tatap_muka" => 'required',
                // "bobot_pratikum" => 'required',
                // "bobot_praktek_lapangan" => 'required',
                // "bobot_simulasi" => 'required'
            ]);

            $save = SubstansiKuliah::findOrFail($id);
            $save->nama_sunstansi = $request->nama_substansi;
            $save->programstudy_id = $request->programstudy_id;
            $save->bobot_mata_kuliah = $request->bobot_mata_kuliah ?? 0;
            $save->bobot_tatap_muka = $request->bobot_tatap_muka ?? 0;
            $save->bobot_pratikum = $request->bobot_pratikum ?? 0;
            $save->bobot_praktek_lapangan = $request->bobot_praktek_lapangan ?? 0;
            $save->bobot_simulasi = $request->bobot_simulasi ?? 0;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($save) {
                //redirect dengan pesan sukses
                return redirect()->route("substansikuliah.index")->with(["success" => "Data Berhasil Diubah!"]);
            } else {
                //redirect dengan pesan error
                return redirect()->route("substansikuliah.index")->with(["error" => "Data Gagal Diubah!"]);
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
           $delete =  SubstansiKuliah::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("substansikuliah.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("substansikuliah.index")->with(["error" => "Data Gagal Dihapus!"]);
        }

    }
}
