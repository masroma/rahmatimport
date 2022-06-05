<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Kampus;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KampusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:kampus-view|kampus-create|kampus-edit|kampus-show|kampus-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kampus-view', ['only' => ['index']]);
         $this->middleware('permission:kampus-create', ['only' => ['create','store']]);
         $this->middleware('permission:kampus-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kampus-show', ['only' => ['show']]);
         $this->middleware('permission:kampus-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows('kampus-show');
            $canUpdate = Gate::allows('kampus-edit');
            $canDelete = Gate::allows('kampus-delete');
            $data = Kampus::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kampus/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="kampus/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        }

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
        $canCreate = Gate::allows('kampus-create');
        $name_page = "kampus";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('akademik::kampus.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "kampus";
        $province = Province::all();

        $data = array(
            'page' => $name_page,
            'province' => $province,

        );

        return view('akademik::kampus.create')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_kampus' => 'required',
            'cabang_kampus' => 'required',
            'email' => 'email',
            'telephone' => 'numeric'
        ]);

        $save = new Kampus();
        $save->nama_kampus = $request->nama_kampus ?? 'universitas paramadina';
        $save->kode_kampus = $request->kode_kampus;
        $save->cabang_kampus = $request->cabang_kampus;
        $save->telephone = $request->telephone ?? null;
        $save->faximile = $request->faximile ?? null;
        $save->email = $request->email ?? null;
        $save->website = $request->website ?? null;
        $save->save();
        // DB::commit();

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('kampus.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kampus.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        $kampus = Kampus::with('address')->find($id);

        $name_page = "kampus";
        $data = array(
            'page' => $name_page,
            'kampus' => $kampus
        );
        return view('akademik::kampus.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $kampus = Kampus::find($id);
        $name_page = "kampus";
        $data = array(
            'page' => $name_page,
            'kampus' => $kampus
        );
        return view('akademik::kampus.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kode_kampus' => 'required',
            'cabang_kampus' => 'required',
            'email' => 'email',
            'telephone' => 'numeric'
        ]);

        $update = Kampus::find($id);
        $update->kode_kampus = $request->kode_kampus;
        $update->cabang_kampus = $request->cabang_kampus;
        $update->telephone = $request->telephone ?? null;
        $update->faximile = $request->faximile ?? null;
        $update->email = $request->email ?? null;
        $update->website = $request->website ?? null;
        $update->save();


        if ($update) {
            //redirect dengan pesan sukses
            return redirect()->route('kampus.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kampus.index')->with(['error' => 'Data Gagal Diubah!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Kampus::find($id)->delete();
        return redirect()->route('kampus.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
