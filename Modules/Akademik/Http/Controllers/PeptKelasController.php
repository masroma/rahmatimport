<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JenisSemester;
use App\Models\PeptBatch;
use App\Models\PeptKelas;
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

class PeptKelasController extends Controller
{

     /**
     * Display a listing of the resource.
     * @return Renderable
     */


    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:peptkelas-view|peptkelas-create|peptkelas-edit|peptkelas-show|peptkelas-delete', ['only' => ['index','store']]);
         $this->middleware('permission:peptkelas-view', ['only' => ['index']]);
         $this->middleware('permission:peptkelas-create', ['only' => ['create','store']]);
         $this->middleware('permission:peptkelas-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:peptkelas-show', ['only' => ['show']]);
         $this->middleware('permission:peptkelas-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('peptkelas-show');
            $canUpdate = Gate::allows('peptkelas-edit');
            $canDelete = Gate::allows('peptkelas-delete');
            $data = PeptKelas::all(); //query
            return DataTables::of($data)

                    ->addColumn('jenissemester', function($data){
                        return $data->Jenissemester->Tahunajaran->tahun_ajaran .'-'. $data->Jenissemester->jenis_semester;
                    })

                    ->addColumn('tanggalpelaksanaan', function($data){
                        return Carbon::parse($data->tanggal_pelaksanaan)->isoFormat('D MMMM Y');
                    })

                    ->addColumn('tanggalselesaipelaksanaan', function($data){
                        return Carbon::parse($data->tanggal_selesai_pelaksanaan)->isoFormat('D MMMM Y');
                    })



                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="peptkelas/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="peptkelas/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('peptkelas-create');
        $name_page = "peptkelas";
        $title = "PEPT Kelas";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::peptkelas.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $batch = PeptBatch::all();
        $jenissemester  = JenisSemester::all();
        $name_page = "peptkelas";
        $title = "PEPT Kelas";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'jenissemester' => $jenissemester,
            'batch'=>$batch
        );

        return view('akademik::peptkelas.create')->with($data);

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
                'peptbatch_id' => 'required',
                'tanggal_pelaksanaan' => 'required',
                'tanggal_selesai_pelaksanaan' => 'required'
            ]);

            $save = new peptkelas();
            $save->jenissemester_id = $request->jenissemester_id;
            $save->nama_Kelas = $request->nama_Kelas;
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
            return redirect()->route('peptkelas.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('peptkelas.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $peptkelas = peptkelas::findOrFail($id);
        $name_page = "peptkelas";
        $title = "PEPT Kelas";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'peptkelas' => $peptkelas,
            'jenissemester' => $jenissemester
        );
        return view('akademik::peptkelas.edit')->with($data);
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
                'nama_Kelas' => 'required',
                'tanggal_pendaftaran' => 'required',
                'tanggal_tutup_pendaftaran' => 'required'
            ]);


            $save = peptkelas::findOrFail($id);
            $save->jenissemester_id = $request->jenissemester_id;
            $save->nama_Kelas = $request->nama_Kelas;
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
            return redirect()->route('peptkelas.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('peptkelas.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  peptkelas::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("peptkelas.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("peptkelas.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
