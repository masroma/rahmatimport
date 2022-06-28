<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\StatusMahasiswa;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class StatusMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:statusmahasiswa-view|statusmahasiswa-create|statusmahasiswa-edit|statusmahasiswa-show|statusmahasiswa-delete', ['only' => ['index','store']]);
         $this->middleware('permission:statusmahasiswa-view', ['only' => ['index']]);
         $this->middleware('permission:statusmahasiswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:statusmahasiswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:statusmahasiswa-show', ['only' => ['show']]);
         $this->middleware('permission:statusmahasiswa-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            $data = StatusMahasiswa::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="statusmahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="statusmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('statusmahasiswa-create');
        $name_page = "statusmahasiswa";
        $title = "status mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::statusmahasiswa.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "status_mahasiswa",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Status Mahasiswa"
            ],
        ];

        $name_page = "statusmahasiswa";
        $title = "status mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::statusmahasiswa.create')->with($data);
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
                'status_mahasiswa' => 'required'
            ]);

            $save = new StatusMahasiswa();
            $save->status_mahasiswa = $request->status_mahasiswa;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('statusmahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('statusmahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $statusmahasiswa = StatusMahasiswa::findOrFail($id);

        $form = [
            0 => [
                "name" => "status_mahasiswa",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $statusmahasiswa->status_mahasiswa,
                "placeholder" =>"Status Mahasiswa"
            ],

        ];

        $name_page = "statusmahasiswa";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'statusmahasiswa' => $statusmahasiswa
        );
        return view('akademik::statusmahasiswa.edit')->with($data);
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
                'status_mahasiswa' => 'required'
            ]);

            $save = StatusMahasiswa::findOrFail($id);
            $save->status_mahasiswa = $request->status_mahasiswa;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('statusmahasiswa.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('statusmahasiswa.index')->with(['error' => 'Data Gagal Diubah!']);
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
           $delete =  StatusMahasiswa::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("statusmahasiswa.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("statusmahasiswa.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
