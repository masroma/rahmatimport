<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:jurusan-view|jurusan-create|jurusan-edit|jurusan-show|jurusan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jurusan-view', ['only' => ['index']]);
         $this->middleware('permission:jurusan-create', ['only' => ['create','store']]);
         $this->middleware('permission:jurusan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jurusan-show', ['only' => ['show']]);
         $this->middleware('permission:jurusan-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('jurusan-show');
            $canUpdate = Gate::allows('jurusan-edit');
            $canDelete = Gate::allows('jurusan-delete');
            $data = Jurusan::with('fakultas')->all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jurusan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jurusan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('jurusan-create');
        $name_page = "jurusan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('akademik::jurusan.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "jurusan";
        $fakultas = Fakultas::all();
        $data = array(
            'page' => $name_page,
            'fakultas' => $fakultas

        );

        return view('akademik::jurusan.create')->with($data);
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
                'nama_jurusan' => 'required',
                'fakultas_id' => 'required'
            ]);

            $save = new jurusan();
            $save->fakultas_id = $request->fakultas_id;
            $save->nama_jurusan = $request->nama_jurusan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jurusan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jurusan.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $jurusan = jurusan::findOrFail($id);


        $name_page = "jurusan";
        $fakultas = Fakultas::all();

        $data = array(
            'page' => $name_page,
            'jurusan' => $jurusan,
            'fakultas' => $fakultas
        );
        return view('akademik::jurusan.edit')->with($data);
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
                'kode_jurusan' => 'required',
                'fakultas_id' => 'required',

            ]);

            $update = jurusan::find($id);
            $update->fakultas_id = $request->fakultas_id;
            $update->nama_jurusan = $request->nama_jurusan;

            $update->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('jurusan.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('jurusan.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        jurusan::find($id)->delete();
        return redirect()->route('jurusan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
