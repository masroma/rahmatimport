<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\TahunAjaran;
use App\Models\JenisSemester;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:tahunajaran-view|tahunajaran-create|tahunajaran-edit|tahunajaran-show|tahunajaran-delete', ['only' => ['index','store']]);
         $this->middleware('permission:tahunajaran-view', ['only' => ['index']]);
         $this->middleware('permission:tahunajaran-create', ['only' => ['create','store']]);
         $this->middleware('permission:tahunajaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:tahunajaran-show', ['only' => ['show']]);
         $this->middleware('permission:tahunajaran-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('tahunajaran-show');
            $canUpdate = Gate::allows('tahunajaran-edit');
            $canDelete = Gate::allows('tahunajaran-delete');
            $data = TahunAjaran::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="tahunajaran/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="tahunajaran/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $semester = JenisSemester::with('Tahunajaran')->get();
        $canCreate = Gate::allows('tahunajaran-create');
        $name_page = "tahunajaran";
        $title = "Tahun Ajaran";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'semester' => $semester
        );
        return view('akademik::tahunajaran.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "tahunajaran";
        $title = "Tahun Ajaran";
        $data = array(
            'page' => $name_page,
            'title' => $title

        );

        return view('akademik::tahunajaran.create')->with($data);
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
                'tahun_ajaran' => 'required'
            ]);

            $save = new TahunAjaran();
            $save->tahun_ajaran = $request->tahun_ajaran;
            $save->save();

            $semester = ['genap','ganjil'];
            foreach($semester as $sm){
                $savesemester = new JenisSemester();
                $savesemester->tahunajaran_id = $save->id;
                $savesemester->jenis_semester = $sm;
                $savesemester->save();
            }

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('tahunajaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('tahunajaran.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $tahunajaran = TahunAjaran::findOrFail($id);
        $name_page = "tahunajaran";
        $title = "Tahun Ajaran";
        $data = array(
            'page' => $name_page,
            'tahunajaran' => $tahunajaran,
            'title' => $title
        );
        return view('akademik::tahunajaran.edit')->with($data);
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
                'tahun_ajaran' => 'required'

            ]);

            $update = TahunAjaran::find($id);
            $update->tahun_ajaran = $request->tahun_ajaran;
            $update->save();

            $delete = JenisSemester::where('tahunajaran_id', $id)->delete();

            $semester = ['genap','ganjil'];
            foreach($semester as $sm){
                $savesemester = new JenisSemester();
                $savesemester->tahunajaran_id = $update->id;
                $savesemester->jenis_semester = $sm;
                $savesemester->save();
            }

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('tahunajaran.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('tahunajaran.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    public function updateStatus(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
           $id = $request->id;
            $update = JenisSemester::find($id);
            $update->active = 1;
            $update->save();
          
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('tahunajaran.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('tahunajaran.index')->with(['error' => 'Data Gagal Diubah!']);
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
            $delete = TahunAjaran::find($id)->delete();
                DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Dihapus!']);
        }

    }
}
