<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProgramStudy;
use App\Models\Jurusan;
use App\Models\JenjangPendidikan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ProgramStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:programstudy-view|programstudy-create|programstudy-edit|programstudy-show|programstudy-delete', ['only' => ['index','store']]);
         $this->middleware('permission:programstudy-view', ['only' => ['index']]);
         $this->middleware('permission:programstudy-create', ['only' => ['create','store']]);
         $this->middleware('permission:programstudy-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:programstudy-show', ['only' => ['show']]);
         $this->middleware('permission:programstudy-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('programstudy-show');
            $canUpdate = Gate::allows('programstudy-edit');
            $canDelete = Gate::allows('programstudy-delete');
            $data = ProgramStudy::with('jenjang','jurusan')->get();
            return DataTables::of($data)

                    ->addColumn('kodes', function($data){
                        return $data->kode ? $data->kode : 'belum ada kode';
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="programstudy/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="programstudy/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('programstudy-create');
        $name_page = "programstudy";
        $title = "Program Study";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::programstudy.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "programstudy";
        $jenjang = JenjangPendidikan::all();
        $jurusan = Jurusan::all();

        $title = "Program Study";
        $data = array(
            'page' => $name_page,
            'jenjang' => $jenjang,
            'title' => $title,
            'jurusan' => $jurusan

        );

        return view('akademik::programstudy.create')->with($data);
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
                'nama_program_study' => 'required',
                'jenjang_id' => 'required',
                'kode' => 'required'
            ]);

            $save = new ProgramStudy();
            $save->jenjang_id = $request->jenjang_id;
            $save->nama_program_study = $request->nama_program_study;
            $save->kode = $request->kode;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('programstudy.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('programstudy.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $programstudy = ProgramStudy::findOrFail($id);

        $jurusan = Jurusan::all();
        $name_page = "programstudy";
        $jenjang = JenjangPendidikan::all();
        $title = "Program study";
        $data = array(
            'page' => $name_page,
            'programstudy' => $programstudy,
            'jenjang' => $jenjang,
            'title' => $title,
            'jurusan' => $jurusan
        );
        return view('akademik::programstudy.edit')->with($data);
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
                'nama_program_study' => 'required',
                'jenjang_id' => 'required',
                'kode' => 'required'

            ]);

            $update = ProgramStudy::find($id);
            $update->jenjang_id = $request->jenjang_id;
            $update->nama_program_study = $request->nama_program_study;
            $update->kode = $request->kode;
            $update->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('programstudy.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('programstudy.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        ProgramStudy::find($id)->delete();
        return redirect()->route('programstudy.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
