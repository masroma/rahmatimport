<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\CutLockTime;
use App\Models\JenisSemester;
use App\Models\KategoriKegiatan;
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

class CutLockTimeController extends Controller
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
         $this->middleware('permission:cutlocktime-view|cutlocktime-create|cutlocktime-edit|cutlocktime-show|cutlocktime-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cutlocktime-view', ['only' => ['index']]);
         $this->middleware('permission:cutlocktime-create', ['only' => ['create','store']]);
         $this->middleware('permission:cutlocktime-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cutlocktime-show', ['only' => ['show']]);
         $this->middleware('permission:cutlocktime-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('cutlocktime-show');
            $canUpdate = Gate::allows('cutlocktime-edit');
            $canDelete = Gate::allows('cutlocktime-delete');
            $data = CutLockTime::with('Semester','Semester.TahunAjaran')->get(); //query
            return DataTables::of($data)

                    ->addColumn('start', function($data){
                        return Carbon::parse($data->start_tanggal)->isoFormat('D MMMM Y') .' '. Carbon::parse($data->start_time)->format('H:i');
                    })
                    ->addColumn('end', function($data){
                        return Carbon::parse($data->end_tanggal)->isoFormat('D MMMM Y') .' '. Carbon::parse($data->end_time)->format('H:i');
                    })

                    ->addColumn('tahunajaran', function($data){
                        return $data->semester->jenis_semester .' '. $data->semester->tahunajaran->tahun_ajaran;
                    })
                   
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="cutlocktime/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="cutlocktime/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('cutlocktime-create');
        $name_page = "cutlocktime";
        $title = "cut lock time";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::cutlocktime.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $tahunajaran = JenisSemester::with('Tahunajaran')->get();
        $name_page = "cutlocktime";
        $title = "cut lock time";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'tahunajaran' => $tahunajaran
        );

        return view('akademik::cutlocktime.create')->with($data);

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
                'key' => 'required',
                'tahunajaran_id' => 'required',
                'start_tanggal' => 'required',
                'start_time' => 'required',
                'end_tanggal' => 'required',
                'end_time' => 'required',
            ]);

            $save = new CutLockTime();
            $save->key = $request->key;
            $save->tahunajaran_id = $request->tahunajaran_id;
            $save->start_tanggal = $request->start_tanggal;
            $save->start_time = $request->start_time;
            $save->end_tanggal = $request->end_tanggal;
            $save->end_time = $request->end_time;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('cutlocktime.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('cutlocktime.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $cutlocktime = CutLockTime::findOrFail($id);
        $tahunajaran = JenisSemester::with('Tahunajaran')->get();
        $name_page = "cutlocktime";
        $title = "cut lock time";
        $data = array(
            'page' => $name_page,
            'tahunajaran' => $tahunajaran,
            'title' => $title,
            'cutlocktime' => $cutlocktime
        );
        return view('akademik::cutlocktime.edit')->with($data);
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
                'key' => 'required',
                'tahunajaran_id' => 'required',
                'start_tanggal' => 'required',
                'start_time' => 'required',
                'end_tanggal' => 'required',
                'end_time' => 'required',
            ]);

            $save = CutLockTime::findOrFail($id);
            $save->key = $request->key;
            $save->tahunajaran_id = $request->tahunajaran_id;
            $save->start_tanggal = $request->start_tanggal;
            $save->start_time = $request->start_time;
            $save->end_tanggal = $request->end_tanggal;
            $save->end_time = $request->end_time;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('cutlocktime.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('cutlocktime.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  CutLockTime::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("cutlocktime.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("cutlocktime.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
