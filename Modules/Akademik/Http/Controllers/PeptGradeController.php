<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\PeptGrade;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Carbon\Carbon;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PeptGradeController extends Controller
{

     /**
     * Display a listing of the resource.
     * @return Renderable
     */


    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:peptgrade-view|peptgrade-create|peptgrade-edit|peptgrade-show|peptgrade-delete', ['only' => ['index','store']]);
         $this->middleware('permission:peptgrade-view', ['only' => ['index']]);
         $this->middleware('permission:peptgrade-create', ['only' => ['create','store']]);
         $this->middleware('permission:peptgrade-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:peptgrade-show', ['only' => ['show']]);
         $this->middleware('permission:peptgrade-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('peptgrade-show');
            $canUpdate = Gate::allows('peptgrade-edit');
            $canDelete = Gate::allows('peptgrade-delete');
            $data = PeptGrade::all(); //query
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="peptgrade/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="peptgrade/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('peptgrade-create');
        $name_page = "peptgrade";
        $title = "PEPT Grade";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::peptgrade.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "peptgrade";
        $title = "PEPT Grade";
        $data = array(
            'page' => $name_page,
            'title' => $title
        );

        return view('akademik::peptgrade.create')->with($data);

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
                'nilai_grade' => 'required',
                'tujuan' => 'required',
            ]);

            $save = new PeptGrade();
            $save->nilai_grade = $request->nilai_grade;
            $save->tujuan = $request->tujuan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('peptgrade.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('peptgrade.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $peptgrade = peptgrade::findOrFail($id);
        $name_page = "peptgrade";
        $title = "PEPT Grade";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'peptgrade' => $peptgrade
        );
        return view('akademik::peptgrade.edit')->with($data);
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
                'nilai_grade' => 'required',
                'tujuan' => 'required',
            ]);

            $save = peptgrade::findOrFail($id);
            $save->nilai_grade = $request->nilai_grade;
            $save->tujuan = $request->tujuan;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('peptgrade.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('peptgrade.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  PeptGrade::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("peptgrade.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("peptgrade.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
