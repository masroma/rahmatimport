<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JenjangPendidikan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class JenjangPendidikanController extends Controller
{
   /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:jenjangpendidikan-view|jenjangpendidikan-create|jenjangpendidikan-edit|jenjangpendidikan-show|jenjangpendidikan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jenjangpendidikan-view', ['only' => ['index']]);
         $this->middleware('permission:jenjangpendidikan-create', ['only' => ['create','store']]);
         $this->middleware('permission:jenjangpendidikan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jenjangpendidikan-show', ['only' => ['show']]);
         $this->middleware('permission:jenjangpendidikan-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('jenjangpendidikan-show');
            $canUpdate = Gate::allows('jenjangpendidikan-edit');
            $canDelete = Gate::allows('jenjangpendidikan-delete');
            $data = JenjangPendidikan::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jenjangpendidikan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jenjangpendidikan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('jenjangpendidikan-create');
        $name_page = "jenjangpendidikan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('akademik::jenjangpendidikan.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "jenjangpendidikan";
        $title = "jenjang pendidikan";

        $data = array(
            'page' => $name_page,
            'title' => $title

        );

        return view('akademik::jenjangpendidikan.create')->with($data);
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
                'nama_jenjang' => 'required'
            ]);

            $save = new jenjangpendidikan();
            $save->nama_jenjang = $request->nama_jenjang;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jenjangpendidikan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jenjangpendidikan.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $jenjangpendidikan = JenjangPendidikan::findOrFail($id);
        $name_page = "jenjangpendidikan";
        $data = array(
            'page' => $name_page,
            'jenjangpendidikan' => $jenjangpendidikan,
        );
        return view('akademik::jenjangpendidikan.edit')->with($data);
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
                'nama_jenjang' => 'required',
            ]);

            $update = JenjangPendidikan::find($id);
            $update->nama_jenjang = $request->nama_jenjang;
            $update->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('jenjangpendidikan.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('jenjangpendidikan.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        JenjangPendidikan::find($id)->delete();
        return redirect()->route('jenjangpendidikan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
