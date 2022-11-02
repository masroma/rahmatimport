<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasKuliahMahasiswa;
use App\Models\JenisSemester;
use App\Models\Mahasiswa;
use App\Models\StatusMahasiswa;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AktivitasKuliahMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:aktivitaskuliahmahasiswa-view|aktivitaskuliahmahasiswa-create|aktivitaskuliahmahasiswa-edit|aktivitaskuliahmahasiswa-show|aktivitaskuliahmahasiswa-delete', ['only' => ['index','store']]);
         $this->middleware('permission:aktivitaskuliahmahasiswa-view', ['only' => ['index']]);
         $this->middleware('permission:aktivitaskuliahmahasiswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:aktivitaskuliahmahasiswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:aktivitaskuliahmahasiswa-show', ['only' => ['show']]);
         $this->middleware('permission:aktivitaskuliahmahasiswa-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            $data = AktivitasKuliahMahasiswa::all();
            
            return DataTables::of($data)
                    ->addColumn('mahasiswa', function($data){
                        return $data->Mahasiswa->nama ;
                    })
                    ->addColumn('semester', function($data){
                        foreach($data->Semester->tahun_ajarans as $ta) {
                            $var_ta = $ta->tahun_ajaran;
                            return $var_ta ."-" . $data->Semester->jenis_semester;
                        }
                    })
                    ->addColumn('status', function($data){
                        return $data->Status->status_mahasiswa;
                    })
                    ->addColumn('biaya', function($data){
                        return "Rp. ".number_format($data->biaya_kuliah);
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="aktivitaskuliahmahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitaskuliahmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        // $datas = AktivitasKuliahMahasiswa::with();
        $canCreate = Gate::allows('aktivitaskuliahmahasiswa-create');
        $name_page = "aktivitaskuliahmahasiswa";
        $title = "aktivitas kuliah mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::aktivitaskuliahmahasiswa.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        $mahasiswa = Mahasiswa::all();
        $status = StatusMahasiswa::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "mahasiswa_id",
                "type" => "select",
                "relasi" => $mahasiswa,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Mahasiswa",
                "value" =>"nama"
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Semester",
                "value" =>"jenis_semester"
            ],
            2 => [
                "name" => "status_id",
                "type" => "select",
                "relasi" => $status,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Status Mahasiswa",
                "value" =>"status_mahasiswa"
            ],
            3 => [
                "name" => "ips",
                "type" => "number",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"IPS",
            ],
            4 => [
                "name" => "ipk",
                "type" => "number",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"IPK",
            ],
            5 => [
                "name" => "jumlah_sks_semester",
                "type" => "number",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Jumlah SKS Semester",
            ],
            6 => [
                "name" => "sks_total",
                "type" => "number",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Total SKS",
            ],
            7 => [
                "name" => "biaya_kuliah",
                "type" => "number",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Biaya Kuliah",
            ],
        ];

        $name_page = "aktivitaskuliahmahasiswa";
        $title = "aktivitas kuliah mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'mahasiswa'=>$mahasiswa,
            'status'=>$status,
            'jenis' =>$jenis
        );

        return view('akademik::aktivitaskuliahmahasiswa.create')->with($data);
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
                'semester_id' => 'required',
                'status_id' => 'required',
                'ips' => 'required',
                'ipk' => 'required',
                'jumlah_sks_semester' => 'required',
                'sks_total' => 'required',
                'biaya_kuliah' => 'required'
            ]);

            $save = new AktivitasKuliahMahasiswa();
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->semester_id = $request->semester_id;
            $save->status_id = $request->status_id;
            $save->ips = $request->ips;
            $save->ipk = $request->ipk;
            $save->jumlah_sks_semester = $request->jumlah_sks_semester;
            $save->sks_total = $request->sks_total;
            $save->biaya_kuliah = $request->biaya_kuliah;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('aktivitaskuliahmahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('aktivitaskuliahmahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $aktivitas = AktivitasKuliahMahasiswa::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        $status = StatusMahasiswa::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "mahasiswa_id",
                "type" => "select",
                "relasi" => $mahasiswa,
                "col" => "s6",
                "data" => $aktivitas->mahasiswa_id,
                "placeholder" =>"Mahasiswa",
                "value" =>"nama"
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s6",
                "data" => $aktivitas->semester_id,
                "placeholder" =>"Semester",
                "value" =>"jenis_semester"
            ],
            2 => [
                "name" => "status_id",
                "type" => "select",
                "relasi" => $status,
                "col" => "s6",
                "data" => $aktivitas->status_id,
                "placeholder" =>"Status Mahasiswa",
                "value" =>"status_mahasiswa"
            ],
            3 => [
                "name" => "ips",
                "type" => "number",
                "col" => "s6",
                "data" => $aktivitas->ips,
                "placeholder" =>"IPS",
            ],
            4 => [
                "name" => "ipk",
                "type" => "number",
                "col" => "s6",
                "data" => $aktivitas->ipk,
                "placeholder" =>"IPK",
            ],
            5 => [
                "name" => "jumlah_sks_semester",
                "type" => "number",
                "col" => "s6",
                "data" => $aktivitas->jumlah_sks_semester,
                "placeholder" =>"Jumlah SKS Semester",
            ],
            6 => [
                "name" => "sks_total",
                "type" => "number",
                "col" => "s6",
                "data" => $aktivitas->sks_total,
                "placeholder" =>"Total SKS",
            ],
            7 => [
                "name" => "biaya_kuliah",
                "type" => "number",
                "col" => "s6",
                "data" => $aktivitas->biaya_kuliah,
                "placeholder" =>"Biaya Kuliah",
            ],
        ];

        $name_page = "aktivitaskuliahmahasiswa";
        $title = "aktivitas kuliah mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'mahasiswa'=>$mahasiswa,
            'status'=>$status,
            'jenis' =>$jenis,
            'aktivitas'=>$aktivitas
        );
        return view('akademik::aktivitaskuliahmahasiswa.edit')->with($data);
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
                'semester_id' => 'required',
                'status_id' => 'required',
                'ips' => 'required',
                'ipk' => 'required',
                'jumlah_sks_semester' => 'required',
                'sks_total' => 'required',
                'biaya_kuliah' => 'required'
            ]);

            $save = AktivitasKuliahMahasiswa::findOrFail($id);
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->semester_id = $request->semester_id;
            $save->status_id = $request->status_id;
            $save->ips = $request->ips;
            $save->ipk = $request->ipk;
            $save->jumlah_sks_semester = $request->jumlah_sks_semester;
            $save->sks_total = $request->sks_total;
            $save->biaya_kuliah = $request->biaya_kuliah;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('aktivitaskuliahmahasiswa.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('aktivitaskuliahmahasiswa.index')->with(['error' => 'Data Gagal Diubah!']);
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
           $delete =  AktivitasKuliahMahasiswa::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("aktivitaskuliahmahasiswa.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("aktivitaskuliahmahasiswa.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
