<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\KategoriInformasi;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KategoriInformasiController extends Controller
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
         $this->middleware('permission:kategoriinformasi-view|kategoriinformasi-create|kategoriinformasi-edit|kategoriinformasi-show|kategoriinformasi-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kategoriinformasi-view', ['only' => ['index']]);
         $this->middleware('permission:kategoriinformasi-create', ['only' => ['create','store']]);
         $this->middleware('permission:kategoriinformasi-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kategoriinformasi-show', ['only' => ['show']]);
         $this->middleware('permission:kategoriinformasi-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('kategoriinformasi-show');
            $canUpdate = Gate::allows('kategoriinformasi-edit');
            $canDelete = Gate::allows('kategoriinformasi-delete');
            $data = KategoriInformasi::all(); //query
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kategoriinformasi/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="kategoriinformasi/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('kategoriinformasi-create');
        $name_page = "kategoriinformasi";
        $title = "nama kategori";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::kategoriinformasi.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "nama_kategori",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"nama kategori"
            ],

        ];

        $name_page = "kategoriinformasi";
        $title = "kategori";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::kategoriinformasi.create')->with($data);

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
                'nama_kategori' => 'required'
            ]);

            $save = new kategoriinformasi();
            $save->nama_kategori = $request->nama_kategori;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('kategoriinformasi.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kategoriinformasi.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $kategoriinformasi = kategoriinformasi::findOrFail($id);
        $form = [
            0 => [
                "name" => "nama_kategori",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $kategoriinformasi->nama_kategori,
                "placeholder" =>"nama kategori"
            ],
        ];

        $name_page = "kategoriinformasi";
        $title = "kategori";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'kategoriinformasi' => $kategoriinformasi
        );
        return view('akademik::kategoriinformasi.edit')->with($data);
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
                'nama_kategori' => 'required'
            ]);

            $save = kategoriinformasi::findOrFail($id);
            $save->nama_kategori = $request->nama_kategori;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('kategoriinformasi.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kategoriinformasi.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  kategoriinformasi::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("kategoriinformasi.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("kategoriinformasi.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
