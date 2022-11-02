<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\DosenPenugasan;
use App\Models\Dosen;
use App\Models\Kampus;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PenugasanDosenController extends Controller
{
    // lagi ngantuk bos
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:penugasandosen-view|penugasandosen-create|penugasandosen-edit|penugasandosen-show|penugasandosen-delete', ['only' => ['index','store']]);
         $this->middleware('permission:penugasandosen-view', ['only' => ['index']]);
         $this->middleware('permission:penugasandosen-create', ['only' => ['create','store']]);
         $this->middleware('permission:penugasandosen-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penugasandosen-show', ['only' => ['show']]);
         $this->middleware('permission:penugasandosen-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('penugasandosen-show');
            $canUpdate = Gate::allows('penugasandosen-edit');
            $canDelete = Gate::allows('penugasandosen-delete');
            $data = DosenPenugasan::with('Kampus','Jurusan','Dosen','Tahunajaran')->get();
            return DataTables::of($data)
                    ->addColumn('tanggalsurat', function($data){
                        return Carbon::parse($data->tanggal_surat_tugas)->isoFormat('D MMMM Y');
                    })

                    ->addColumn('tmtsurat', function($data){
                        return Carbon::parse($data->tmt_surat_tugas)->isoFormat('D MMMM Y');
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="penugasandosen/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="penugasandosen/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $data = DosenPenugasan::with('Kampus','Jurusan','Dosen','Tahunajaran')->get();
        // dd($data);
        $canCreate = Gate::allows('penugasandosen-create');
        $name_page = "penugasandosen";
        $title = "Penugasan Dosen";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::penugasandosen.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "penugasandosen";
        $tahunajaran = TahunAjaran::all();
        $jurusan = Jurusan::all();
        $dosen = Dosen::all();

        $kampus = Kampus::all();
        $title = "Program Study";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'jurusan' => $jurusan,
            'tahunajaran' => $tahunajaran,
            'dosen' => $dosen,
            'kampus' => $kampus
        );

        return view('akademik::penugasandosen.create')->with($data);
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
                'kampus_id' => 'required',
                'jurusan_id' => 'required',
                'dosen_id' => 'required',
                'tahunajaran_id' => 'required',
                'no_surat_tugas' => 'required',
                'tanggal_surat_tugas' => 'required',
                'tmt_surat_tugas' => 'required'
            ]);

            $save = new DosenPenugasan();
            $save->kampus_id = $request->kampus_id;
            $save->jurusan_id = $request->jurusan_id;
            $save->dosen_id = $request->dosen_id;
            $save->tahunajaran_id = $request->tahunajaran_id;
            $save->no_surat_tugas = $request->no_surat_tugas;
            $save->tanggal_surat_tugas = $request->tanggal_surat_tugas;
            $save->TMT_surat_tugas = $request->tmt_surat_tugas;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('penugasandosen.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('penugasandosen.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $penugasandosen = DosenPenugasan::findOrFail($id);

        $tahunajaran = TahunAjaran::all();
        $jurusan = Jurusan::all();
        $dosen = Dosen::all();
        $kampus = Kampus::all();
        $name_page = "penugasandosen";
        $title = "Program study";
        $data = array(
            'page' => $name_page,
            'penugasandosen' => $penugasandosen,
            'title' => $title,
            'jurusan' => $jurusan,
            'dosen' => $dosen,
            'kampus' => $kampus,
            'tahunajaran' => $tahunajaran
        );
        return view('akademik::penugasandosen.edit')->with($data);
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
                'kampus_id' => 'required',
                'jurusan_id' => 'required',
                'dosen_id' => 'required',
                'tahunajaran_id' => 'required',
                'no_surat_tugas' => 'required',
                'tanggal_surat_tugas' => 'required',
                'tmt_surat_tugas' => 'required'
            ]);

            $update = DosenPenugasan::find($id);
            $update->kampus_id = $request->kampus_id;
            $update->jurusan_id = $request->jurusan_id;
            $update->dosen_id = $request->dosen_id;
            $update->tahunajaran_id = $request->tahunajaran_id;
            $update->no_surat_tugas = $request->no_surat_tugas;
            $update->tanggal_surat_tugas = $request->tanggal_surat_tugas;
            $update->TMT_surat_tugas = $request->tmt_surat_tugas;
            $update->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('penugasandosen.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('penugasandosen.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DosenPenugasan::find($id)->delete();
        return redirect()->route('penugasandosen.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
