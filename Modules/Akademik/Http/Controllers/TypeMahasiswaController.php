<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\TypeMahasiswa;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
class TypeMahasiswaController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */
     /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:typemahasiswa-view|typemahasiswa-create|typemahasiswa-edit|typemahasiswa-show|typemahasiswa-delete', ['only' => ['index','store']]);
         $this->middleware('permission:typemahasiswa-view', ['only' => ['index']]);
         $this->middleware('permission:typemahasiswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:typemahasiswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:typemahasiswa-show', ['only' => ['show']]);
         $this->middleware('permission:typemahasiswa-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('typemahasiswa-edit');
            $canDelete = Gate::allows('typemahasiswa-delete');
            $data = TypeMahasiswa::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="typemahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="typemahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

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
        $canCreate = Gate::allows('typemahasiswa-create');
        $name_page = "typemahasiswa";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::typemahasiswa.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "type_mahasiswa",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"nama jalur"
            ],
        ];

        $name_page = "typemahasiswa";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::typemahasiswa.create')->with($data);

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
                'type_mahasiswa' => 'required'
            ]);

            $save = new TypeMahasiswa();
            $save->type_mahasiswa = $request->type_mahasiswa;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('typemahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('typemahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('akademik::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $typemahasiswa = TypeMahasiswa::findOrFail($id);
        $form = [
            0 => [
                "name" => "type_mahasiswa",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $typemahasiswa->type_mahasiswa,
                "placeholder" =>"nama jalur"
            ],
        ];

        $name_page = "typemahasiswa";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'typemahasiswa' => $typemahasiswa
        );
        return view('akademik::typemahasiswa.edit')->with($data);
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
                'type_mahasiswa' => 'required'
            ]);

            $save = TypeMahasiswa::findOrFail($id);
            $save->type_mahasiswa = $request->type_mahasiswa;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('typemahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('typemahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  TypeMahasiswa::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("typemahasiswa.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("typemahasiswa.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
