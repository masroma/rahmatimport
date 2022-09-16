<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JenisSemester;
use App\Models\PeptBatch;
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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PeptBatchController extends Controller
{

     /**
     * Display a listing of the resource.
     * @return Renderable
     */


    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:peptbatch-view|peptbatch-create|peptbatch-edit|peptbatch-show|peptbatch-delete', ['only' => ['index','store']]);
         $this->middleware('permission:peptbatch-view', ['only' => ['index']]);
         $this->middleware('permission:peptbatch-create', ['only' => ['create','store']]);
         $this->middleware('permission:peptbatch-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:peptbatch-show', ['only' => ['show']]);
         $this->middleware('permission:peptbatch-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('peptbatch-show');
            $canUpdate = Gate::allows('peptbatch-edit');
            $canDelete = Gate::allows('peptbatch-delete');
            $data = PeptBatch::with(['Grade','GradeTa'])->get(); //query
            return DataTables::of($data)

                    ->addColumn('jenissemester', function($data){
                        return $data->Jenissemester->Tahunajaran->tahun_ajaran .'-'. $data->Jenissemester->jenis_semester;
                    })

                    ->addColumn('tanggalpendaftaran', function($data){
                        return Carbon::parse($data->tanggal_pendaftaran)->isoFormat('D MMMM Y');
                    })

                    ->addColumn('tanggaltutuppendaftaran', function($data){
                        return Carbon::parse($data->tanggal_tutup_pendaftaran)->isoFormat('D MMMM Y');
                    })

                    ->addColumn('pept', function($data){
                        return $data->Grade ? $data->Grade->nilai_grade : '-';
                    })

                    ->addColumn('peptsidang', function($data){
                        return  $data->Grade ? $data->GradeTa->nilai_grade : '-';
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="peptbatch/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="peptbatch/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('peptbatch-create');
        $name_page = "peptbatch";
        $title = "PEPT Batch";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::peptbatch.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $jenissemester  = JenisSemester::all();
        $name_page = "peptbatch";
        $title = "PEPT Batch";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'jenissemester' => $jenissemester
        );

        return view('akademik::peptbatch.create')->with($data);

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
                'jenissemester_id' => 'required',
                'nama_batch' => 'required',
                'tanggal_pendaftaran' => 'required',
                'tanggal_tutup_pendaftaran' => 'required'
            ]);

            $grade = PeptGrade::all();



            $save = new PeptBatch();
            $save->jenissemester_id = $request->jenissemester_id;
            $save->nama_batch = $request->nama_batch;
            $save->grade_pept = $grade[0]->id;
            $save->grade_sidang = $grade[1]->id;
            $save->tanggal_pendaftaran = $request->tanggal_pendaftaran;
            $save->tanggal_tutup_pendaftaran = $request->tanggal_tutup_pendaftaran;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('peptbatch.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('peptbatch.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $jenissemester  = JenisSemester::all();
        $peptbatch = peptbatch::findOrFail($id);
        $name_page = "peptbatch";
        $title = "PEPT Batch";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'peptbatch' => $peptbatch,
            'jenissemester' => $jenissemester
        );
        return view('akademik::peptbatch.edit')->with($data);
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
                'jenissemester_id' => 'required',
                'nama_batch' => 'required',
                'tanggal_pendaftaran' => 'required',
                'tanggal_tutup_pendaftaran' => 'required'
            ]);


            $save = peptbatch::findOrFail($id);
            $save->jenissemester_id = $request->jenissemester_id;
            $save->nama_batch = $request->nama_batch;
            $save->grade_pept = $save->grade_pept;
            $save->grade_sidang = $save->grade_sidang;
            $save->tanggal_pendaftaran = $request->tanggal_pendaftaran;
            $save->tanggal_tutup_pendaftaran = $request->tanggal_tutup_pendaftaran;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('peptbatch.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('peptbatch.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  PeptBatch::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("peptbatch.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("peptbatch.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
