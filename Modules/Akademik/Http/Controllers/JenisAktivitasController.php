<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JenisAktivitas;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class JenisAktivitasController extends Controller
{

    use ValidatesRequests;
    function __construct()
    {
         $this->middleware('permission:jenisaktivitas-view|jenisaktivitas-create|jenisaktivitas-edit|jenisaktivitas-show|jenisaktivitas-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jenisaktivitas-view', ['only' => ['index']]);
         $this->middleware('permission:jenisaktivitas-create', ['only' => ['create','store']]);
         $this->middleware('permission:jenisaktivitas-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jenisaktivitas-show', ['only' => ['show']]);
         $this->middleware('permission:jenisaktivitas-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            $data = JenisAktivitas::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jenisaktivitas/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jenisaktivitas/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $canCreate = Gate::allows('jenisaktivitas-create');
        $name_page = "jenisaktivitas";
        $title = "aktivitas kuliah mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::jenisaktivitas.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "jenis_aktivitas",
                "type" => "text",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Jenis Aktivitas"
            ],

        ];

        $name_page = "jenisaktivitas";
        $title = "jenis aktivitas";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title
        );

        return view('akademik::jenisaktivitas.create')->with($data);
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
                'jenis_aktivitas' => 'required',
                'kategori' => 'required'
            ]);

            $save = new JenisAktivitas();
            $save->jenis_aktivitas = $request->jenis_aktivitas;
            $save->kategori = $request->kategori;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jenisaktivitas.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jenisaktivitas.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $jenis = JenisAktivitas::findOrFail($id);
        $form = [
            0 => [
                "name" => "jenis_aktivitas",
                "type" => "text",
                "col" => "s6",
                "data" => $jenis->jenis_aktivitas,
                "placeholder" =>"Jenis Aktivitas"
            ],

        ];

        $name_page = "jenisaktivitas";
        $title = "jenis aktivitas";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'jenis'=>$jenis
        );

        return view('akademik::jenisaktivitas.edit')->with($data);
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
                'jenis_aktivitas' => 'required',
                'kategori' => 'required'
            ]);

            $save = JenisAktivitas::findOrFail($id);
            $save->jenis_aktivitas = $request->jenis_aktivitas;
            $save->kategori = $request->kategori;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jenisaktivitas.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jenisaktivitas.index')->with(['error' => 'Data Gagal Diubah!']);
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
           $delete =  JenisAktivitas::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("jenisaktivitas.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("jenisaktivitas.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
