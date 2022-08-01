<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\KelasPerkuliahan;
use App\Models\Krs;
use App\Models\NilaiPerkuliahan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class NilaiPerkuliahanController extends Controller
{
    use ValidatesRequests;


    function __construct()
    {
         $this->middleware("permission:nilaiperkuliahan-view|nilaiperkuliahan-create|nilaiperkuliahan-edit|nilaiperkuliahan-show|nilaiperkuliahan-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:nilaiperkuliahan-view", ["only" => ["index"]]);
         $this->middleware("permission:nilaiperkuliahan-create", ["only" => ["create","store"]]);
         $this->middleware("permission:nilaiperkuliahan-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:nilaiperkuliahan-show", ["only" => ["show"]]);
         $this->middleware("permission:nilaiperkuliahan-delete", ["only" => ["destroy"]]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function data()
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("nilaiperkuliahan-edit");
            $canDelete = Gate::allows("nilaiperkuliahan-delete");
            $data = KelasPerkuliahan::with("Programstudy","Matakuliah","Krs")->withCount(['Krs'])->get();
            return DataTables::of($data)

                    ->addColumn('checkbox', function($data){
                            return ' <label>
                            <input type="checkbox" class="add"  value="'.$data->id.'" onchange="myChecked(this.value)"/>
                            <span></span>
                        </label>';

                    })

                    ->addColumn("programstudy", function($data){
                        return $data->Programstudy->jurusan->nama_jurusan.'-'.$data->Programstudy->jenjang->nama_jenjang;
                    })

                    ->addColumn("matalkuliah", function($data){
                            return $data->Matakuliah->nama_matakuliah;
                    })

                    ->addColumn("kodematalkuliah", function($data){
                        return $data->Matakuliah->kode_matakuliah;
                    })

                    ->addColumn('semesters', function($data){
                        return $data->Jenissemester->Tahunajaran->tahun_ajaran .'-'. $data->Jenissemester->jenis_semester;
                    })

                    ->addColumn('namamatkul', function($data){
                        return $data->Matakuliah->kode_matakuliah.'-'. $data->Matakuliah->nama_matakuliah;;
                    })

                    ->addColumn("namakelas", function($data){
                        return $data->nama_kelas.$data->kode;
                    })

                    ->addColumn('colors', function($data){
                        $input = '<div class="col" style="background-color:'.$data->color.'; height:10px"></div>';
                        return $input;
                    })



                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="nilaiperkuliahan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;
                    })
                    ->rawColumns(['colors','action','checkbox'])
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    "status" => false,
                    "message" => $e->getMessage()
                ]
            );
        }


    }

    public function index()
    {
        $canCreate = Gate::allows("nilaiperkuliahan-create");
        $name_page = "nilaiperkuliahan";
        $title = "Nilai Perkuliahan";
        $data = array(
            "page" => $name_page,
            "canCreate" => $canCreate,
            "title" => $title
        );
        return view("akademik::nilaiperkuliahan.index")->with($data);
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('akademik::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
        $nilaiperkuliahan = KelasPerkuliahan::with("Jenissemester","Jenissemester.tahunajaran","Programstudy","Programstudy.jurusan","Programstudy.jenjang","Matakuliah","Krs")->withCount(['Krs'])->findOrFail($id);
        
       
        // dd($nilaiperkuliahan);
        // dd(json_decode($nilaiperkuliahan->typemahasiswa_id));\

        // ->with(['Nilai' => function($q) use($id){
        //     $q->where('kelas_id', '=', $id);
        // }])
       
        $mahasiswakrs = Krs::with('Mahasiswa','Mahasiswa.Riwayatpendidikan','Mahasiswa.Riwayatpendidikan.programstudy','Mahasiswa.Riwayatpendidikan.programstudy.jurusan')->where('kelas_id',$id)->get();
       
        $name_page = "nilaiperkuliahan";
        $title = "Nilai Perkuliahan";
        $data = array(
            "page" => $name_page,
            "nilaiperkuliahan" => $nilaiperkuliahan,
            "title" => $title,
            "mahasiswa" => $mahasiswakrs
        );
        return view('akademik::nilaiperkuliahan.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request->mahasiswa_id);
        DB::beginTransaction();
        try {
            $cek =  NilaiPerkuliahan::where('kelas_id',$id)->first();

            if($cek == null){
                $mahasiswa = count($request->mahasiswa_id);
                for ($i = 0; $i <= $mahasiswa; $i++) {
                    $save = new NilaiPerkuliahan;
                    $save->mahasiswa_id = $request->mahasiswa_id[$i] ?? 0;
                    $save->kelas_id = $id;
                    $save->nilai_angka = $request->angka[$i] ?? 0;
                    $save->nilai_huruf = $request->huruf[$i] ?? 0;
                    $save->save();
                }
            }else{
                $mahasiswa = count($request->mahasiswa_id);
                NilaiPerkuliahan::where('kelas_id',$id)->delete();
                for ($i = 0; $i <= $mahasiswa; $i++) {
                    $save = new NilaiPerkuliahan;
                    $save->mahasiswa_id = $request->mahasiswa_id[$i] ?? 0;
                    $save->kelas_id = $id;
                    $save->nilai_angka = $request->angka[$i] ?? 0;
                    $save->nilai_huruf = $request->huruf[$i] ?? 0;
                    $save->save();
                }
            }

            NilaiPerkuliahan::where('kelas_id', $id)->where('mahasiswa_id',0)->delete();

            DB::commit();

        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($save) {
                //redirect dengan pesan sukses
                return redirect()->back()->with(["success" => "Data Berhasil Diubah!"]);
            } else {
                //redirect dengan pesan error
                return redirect()->back()->with(["error" => "Data Gagal Diubah!"]);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
