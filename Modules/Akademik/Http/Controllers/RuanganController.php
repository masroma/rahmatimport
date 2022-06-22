<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Kampus;
use App\Models\RuangGedung;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RuanganController extends Controller
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
         $this->middleware('permission:ruangan-view|ruangan-create|ruangan-edit|ruangan-show|ruangan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:ruangan-view', ['only' => ['index']]);
         $this->middleware('permission:ruangan-create', ['only' => ['create','store']]);
         $this->middleware('permission:ruangan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ruangan-show', ['only' => ['show']]);
         $this->middleware('permission:ruangan-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('ruangan-show');
            $canUpdate = Gate::allows('ruangan-edit');
            $canDelete = Gate::allows('ruangan-delete');
            $data = RuangGedung::with('ListKampus')->get();
            return DataTables::of($data)

                    ->addColumn('kampus',function($data){
                        return $data->ListKampus->nama_kampus .'-'.$data->ListKampus->cabang_kampus;
                    })
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="ruangan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="ruangan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('ruangan-create');
        $name_page = "ruangan";
        $title = "ruangan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::ruangan.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $kampus = Kampus::all();
        $p = null;
        $form = [
            0 => [
                "name" => "kampus_id",
                "type" => "select",
                "relasi" => $kampus,
                "col" => "s12",
                "data" => "",
                "placeholder" =>"kampus",
                "id" => "id",
                "value" =>"cabang_kampus",

            ],

            1 => [
                "name" => "kode_ruang",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Kode Ruang"
            ],

            2 => [
                "name" => "nama_ruang",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Nama Ruang"
            ],



        ];

        $name_page = "ruangan";
        $title = "ruangan";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::ruangan.create')->with($data);

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
                'kampus_id' => 'required',
                'nama_ruang' => 'required',
                'kode_ruang' => 'required'
            ]);

            $save = new RuangGedung();
            $save->kampus_id = $request->kampus_id;
            $save->kode_ruang = $request->kode_ruang;
            $save->nama_ruang = $request->nama_ruang;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('ruangan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('ruangan.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $ruangan = RuangGedung::findOrFail($id);
        $kampus = Kampus::all();

        $form = [
            0 => [
                "name" => "kampus_id",
                "type" => "select",
                "relasi" => $kampus,
                "col" => "s12",
                "data" => $ruangan->kampus_id,
                "placeholder" =>"kampus",
                "value" =>"cabang_kampus",
            ],

            1 => [
                "name" => "kode_ruang",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $ruangan->kode_ruang,
                "placeholder" =>"Kode Ruang"
            ],

            2 => [
                "name" => "nama_ruang",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $ruangan->nama_ruang,
                "placeholder" =>"Nama Ruang"
            ],
        ];


        $name_page = "ruangan";
        $title = "ruangan";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'ruangan' => $ruangan
        );
        return view('akademik::ruangan.edit')->with($data);
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
                'kampus_id' => 'required',
                'nama_ruang' => 'required',
                'kode_ruang' => 'required'
            ]);

            $save = RuangGedung::findOrFail($id);
            $save->kampus_id = $request->kampus_id;
            $save->kode_ruang = $request->kode_ruang;
            $save->nama_ruang = $request->nama_ruang;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('ruangan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('ruangan.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  RuangGedung::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("ruangan.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("ruangan.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
