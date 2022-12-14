<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\PenggunaanRuangan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PenggunaanRuangController extends Controller
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
         $this->middleware('permission:penggunaanruang-view|penggunaanruang-create|penggunaanruang-edit|penggunaanruang-show|penggunaanruang-delete', ['only' => ['index','store']]);
         $this->middleware('permission:penggunaanruang-view', ['only' => ['index']]);
         $this->middleware('permission:penggunaanruang-create', ['only' => ['create','store']]);
         $this->middleware('permission:penggunaanruang-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penggunaanruang-show', ['only' => ['show']]);
         $this->middleware('permission:penggunaanruang-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('penggunaanruang-show');
            $canUpdate = Gate::allows('penggunaanruang-edit');
            $canDelete = Gate::allows('penggunaanruang-delete');
            $data = PenggunaanRuangan::get();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="penggunaanruang/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="penggunaanruang/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('penggunaanruang-create');
        $name_page = "penggunaanruang";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::penggunaanruang.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "penggunaan_ruangan",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"penggunaan ruangan"
            ],
        ];

        $name_page = "penggunaanruang";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::penggunaanruang.create')->with($data);

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
                'penggunaan_ruangan' => 'required'
            ]);

            $save = new PenggunaanRuangan();
            $save->penggunaan_ruangan = $request->penggunaan_ruangan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('penggunaanruang.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('penggunaanruang.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $penggunaanruang = PenggunaanRuangan::findOrFail($id);
        $form = [
            0 => [
                "name" => "penggunaan_ruangan",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $penggunaanruang->penggunaan_ruangan,
                "placeholder" =>"penggunaan ruangan"
            ],
        ];

        $name_page = "penggunaanruang";
        $title = "type mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'penggunaanruang' => $penggunaanruang
        );
        return view('akademik::penggunaanruang.edit')->with($data);
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
                'penggunaan_ruangan' => 'required'
            ]);

            $save = PenggunaanRuangan::findOrFail($id);
            $save->penggunaan_ruangan = $request->penggunaan_ruangan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('penggunaanruang.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('penggunaanruang.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  PenggunaanRuangan::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("penggunaanruang.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("penggunaanruang.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
