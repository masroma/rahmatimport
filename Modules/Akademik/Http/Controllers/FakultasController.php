<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Fakultas;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:fakultas-view|fakultas-create|fakultas-edit|fakultas-show|fakultas-delete', ['only' => ['index','store']]);
         $this->middleware('permission:fakultas-view', ['only' => ['index']]);
         $this->middleware('permission:fakultas-create', ['only' => ['create','store']]);
         $this->middleware('permission:fakultas-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:fakultas-show', ['only' => ['show']]);
         $this->middleware('permission:fakultas-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('fakultas-show');
            $canUpdate = Gate::allows('fakultas-edit');
            $canDelete = Gate::allows('fakultas-delete');
            $data = Fakultas::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="fakultas/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="fakultas/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('fakultas-create');
        $name_page = "fakultas";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('akademik::fakultas.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "fakultas";

        $data = array(
            'page' => $name_page,

        );

        return view('akademik::fakultas.create')->with($data);
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
                'nama_fakultas' => 'required',
                'kode_fakultas' => 'required|unique:fakultas,kode_fakultas'
            ]);

            $save = new Fakultas();
            $save->kode_fakultas = $request->kode_fakultas;
            $save->nama_fakultas = $request->nama_fakultas;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('fakultas.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('fakultas.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $fakultas = Fakultas::findOrFail($id);


        $name_page = "fakultas";
        $data = array(
            'page' => $name_page,
            'fakultas' => $fakultas,
        );
        return view('akademik::fakultas.edit')->with($data);
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
                'kode_fakultas' => 'required',
                'nama_fakultas' => 'required',

            ]);

            $update = Fakultas::find($id);
            $update->kode_fakultas = $request->kode_fakultas;
            $update->nama_fakultas = $request->nama_fakultas;

            $update->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('fakultas.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('fakultas.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Fakultas::find($id)->delete();
        return redirect()->route('fakultas.index')
            ->with('success', 'Data berhasil dihapus');
    }

}
