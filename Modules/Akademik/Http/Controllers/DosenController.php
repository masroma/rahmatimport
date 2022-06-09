<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Dosen;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:dosen-view|dosen-create|dosen-edit|dosen-show|dosen-delete', ['only' => ['index','store']]);
         $this->middleware('permission:dosen-view', ['only' => ['index']]);
         $this->middleware('permission:dosen-create', ['only' => ['create','store']]);
         $this->middleware('permission:dosen-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:dosen-show', ['only' => ['show']]);
         $this->middleware('permission:dosen-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows('dosen-show');
            $canUpdate = Gate::allows('dosen-edit');
            $canDelete = Gate::allows('dosen-delete');
            $data = Dosen::all();
            return DataTables::of($data)
                    ->addColumn('tanggallahir', function($data){
                        return Carbon::parse($data->tanggal_lahir)->isoFormat('dddd, D MMMM Y');
                    })
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="dosen/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="dosen/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('dosen-create');
        $name_page = "dosen";
        $title = "Dosen";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::dosen.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $canCreate = Gate::allows('dosen-create');
        $name_page = "dosen";
        $title = "Dosen";
        $province = Province::all();
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'province' => $province
        );
        return view('akademik::dosen.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required',
                'tempat_lahir' => 'required',
                'agama'=>'required',
            ]);

            $save = new Dosen();
            $save->nidn = $request->nidn ?? null;
            $save->nama_dosen = $request->nama;
            $save->tempat_lahir = $request->tempat_lahir;
            $save->jenis_kelamin = $request->jenis_kelamin;
            $save->tanggal_lahir = $request->tanggal_lahir ?? null;
            $save->agama = $request->agama ?? null;
            $save->save();


            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('dosen.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dosen.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function storeDosenDetail(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = new MahasiswaDetail();
            $save->mahasiswa_id = $idMahasiswa;
            $save->kewarganegaraan_id = $request->kewarganegaraan_id ?? null;
            $save->nisn = $request->nisn ?? null;
            $save->email = $request->email ?? null;
            $save->ktp = $request->nik ?? null;
            $save->npwp = $request->npwp ?? null;
            $save->jalan = $request->jalan ??  null;
            $save->telephone = $request->telephone ??  null;
            $save->dusun = $request->dusun ??  null;
            $save->rt = $request->rt ??  null;
            $save->rw = $request->rw ??  null;
            $save->kode_pos = $request->kode_pos ??  null;
            $save->handphone = $request->handphone ??  null;
            $save->penerima_kps = $request->penerima_kps ??  null;
            $save->province_id = $request->province_id ??  null;
            $save->city_id = $request->city_id ??  null;
            $save->district_id = $request->district_id ??  null;
            $save->village_id = $request->village_id ??  null;
            $save->jenis_tinggal = $request->jenis_tinggal ??  null;
            $save->alat_transportasi = $request->alat_transportasi ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
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
        $dosen = Dosen::findOrFail($id);

        $name_page = "dosen";
        $title = "Dosen";

        $data = array(
            'page' => $name_page,
            'dosen' => $dosen,
            'title' => $title,

        );
        return view('akademik::dosen.edit')->with($data);
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
                'nama' => 'required',
                'tempat_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required',
                'agama'=>'required',
                //

            ]);

            $update = Dosen::find($id);
            $update->nidn = $request->nidn ?? null;
            $update->nama_dosen = $request->nama;
            $update->tempat_lahir = $request->tempat_lahir;
            $update->jenis_kelamin = $request->jenis_kelamin;
            $update->tanggal_lahir = $request->tanggal_lahir ?? null;
            $update->agama = $request->agama ?? null;
            $update->save();



            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('dosen.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('dosen.index')->with(['error' => 'Data Gagal Diubah!']);
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
            Dosen::find($id)->delete();


                DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dosen.index')->with('success', 'Data berhasil dihapus');
    }
}
