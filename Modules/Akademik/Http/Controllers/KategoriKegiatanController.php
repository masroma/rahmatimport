<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\KategoriKegiatan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KategoriKegiatanController extends Controller
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
         $this->middleware('permission:kategorikegiatan-view|kategorikegiatan-create|kategorikegiatan-edit|kategorikegiatan-show|kategorikegiatan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kategorikegiatan-view', ['only' => ['index']]);
         $this->middleware('permission:kategorikegiatan-create', ['only' => ['create','store']]);
         $this->middleware('permission:kategorikegiatan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kategorikegiatan-show', ['only' => ['show']]);
         $this->middleware('permission:kategorikegiatan-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('kategorikegiatan-show');
            $canUpdate = Gate::allows('kategorikegiatan-edit');
            $canDelete = Gate::allows('kategorikegiatan-delete');
            $data = KategoriKegiatan::all(); //query
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kategorikegiatan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="kategorikegiatan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('kategorikegiatan-create');
        $name_page = "kategorikegiatan";
        $title = "Kategori Kegiatan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::kategorikegiatan.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "kode",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Kode"
            ],
            1 => [
                "name" => "nama_kategori_kegiatan",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Nama Kategori Kegiatan"
            ],

        ];

        $name_page = "kategorikegiatan";
        $title = "kategori mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::kategorikegiatan.create')->with($data);

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
                'kode' => 'required',
                'nama_kategori_kegiatan' => 'required'
            ]);

            $save = new KategoriKegiatan();
            $save->kode = $request->kode;
            $save->nama_kategori_kegiatan = $request->nama_kategori_kegiatan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('kategorikegiatan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kategorikegiatan.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $kategorikegiatan = KategoriKegiatan::findOrFail($id);
        $form = [
            0 => [
                "name" => "kode",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $kategorikegiatan->kode,
                "placeholder" =>"kode"
            ],

            1 => [
                "name" => "nama_kategori_kegiatan",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $kategorikegiatan->nama_kategori_kegiatan,
                "placeholder" =>"kode"
            ],
        ];

        $name_page = "kategorikegiatan";
        $title = "kategori kegiatan";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'kategorikegiatan' => $kategorikegiatan
        );
        return view('akademik::kategorikegiatan.edit')->with($data);
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
                'kode' => 'required',
                'nama_kategori_kegiatan' => 'required'
            ]);

            $save = KategoriKegiatan::findOrFail($id);
            $save->kode = $request->kode;
            $save->nama_kategori_kegiatan = $request->nama_kategori_kegiatan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('kategorikegiatan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kategorikegiatan.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  KategoriKegiatan::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("kategorikegiatan.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("kategorikegiatan.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
