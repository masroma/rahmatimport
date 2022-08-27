<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JenisSemester;
use App\Models\Mahasiswa;
use App\Models\UnlockKrs;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UnlockKrsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:unlockkrs-view|unlockkrs-create|unlockkrs-edit|unlockkrs-show|unlockkrs-delete', ['only' => ['index','store']]);
         $this->middleware('permission:unlockkrs-view', ['only' => ['index']]);
         $this->middleware('permission:unlockkrs-create', ['only' => ['create','store']]);
         $this->middleware('permission:unlockkrs-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:unlockkrs-show', ['only' => ['show']]);
         $this->middleware('permission:unlockkrs-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('unlockkrs-show');
            $canUpdate = Gate::allows('unlockkrs-edit');
            $canDelete = Gate::allows('unlockkrs-delete');
            $data = UnlockKrs::with('jenissemester.TahunAjaran','mahasiswa')->get();
            return DataTables::of($data)

            
                    ->addColumn('tahunajaran', function($data){
                        return $data->jenissemester->jenis_semester .' '. $data->jenissemester->tahunajaran->tahun_ajaran;
                    })

                    ->addColumn('namamahasiswa', function($data){
                        return $data->mahasiswa->nama;
                    })

                    ->addColumn('nimmahasiswa', function($data){
                        return $data->mahasiswa->nim;
                    })
                

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="unlockkrs/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="unlockkrs/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('unlockkrs-create');
        $name_page = "unlockkrs";
        $title = "Unlock KRS";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::unlockkrs.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $jenissemester = JenisSemester::with('tahunajaran')->get();
        $mahasiswa = Mahasiswa::all();
        $name_page = "unlockkrs";
        $title = "unlock KRS";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'jenissemester' => $jenissemester,
            'mahasiswa' => $mahasiswa

        );

        return view('akademik::unlockkrs.create')->with($data);
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
                'mahasiswa_id' => 'required',
                'jenissemester_id' => 'required',
                'totalkrs'=>'required'
            ]);

            $save = new UnlockKrs();
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->jenissemester_id = $request->jenissemester_id;
            $save->totalkrs = $request->totalkrs;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('unlockkrs.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('unlockkrs.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $jenissemester = JenisSemester::with('tahunajaran')->get();
        $mahasiswa = Mahasiswa::all();
        $unlockkrs = unlockkrs::findOrFail($id);
        $name_page = "unlockkrs";
        $title = "Unlock KRS";
        $data = array(
            'page' => $name_page,
            'unlockkrs' => $unlockkrs,
            'title' => $title,
            'jenissemester' => $jenissemester,
            'mahasiswa' => $mahasiswa
        );
        return view('akademik::unlockkrs.edit')->with($data);
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
                'mahasiswa_id' => 'required',
                'jenissemester_id' => 'required',
                'totalkrs'=>'required'

            ]);

            $save = unlockkrs::find($id);
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->jenissemester_id = $request->jenissemester_id;
            $save->totalkrs = $request->totalkrs;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($save) {
                //redirect dengan pesan sukses
                return redirect()->route('unlockkrs.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('unlockkrs.index')->with(['error' => 'Data Gagal Diubah!']);
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
            $delete = unlockkrs::find($id)->delete();
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
