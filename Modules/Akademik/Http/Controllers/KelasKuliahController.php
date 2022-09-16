<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ProgramStudy;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\JenisSemester;
use App\Models\SubstansiKuliah;
use App\Models\KelasPerkuliahan;
use App\Models\DosenPerkuliahan;
use App\Models\DosenPenugasan;
use App\Models\TypeMahasiswa;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KelasKuliahController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;


    function __construct()
    {
         $this->middleware("permission:kelasperkuliahan-view|kelasperkuliahan-create|kelasperkuliahan-edit|kelasperkuliahan-show|kelasperkuliahan-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:kelasperkuliahan-view", ["only" => ["index"]]);
         $this->middleware("permission:kelasperkuliahan-create", ["only" => ["create","store"]]);
         $this->middleware("permission:kelasperkuliahan-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:kelasperkuliahan-show", ["only" => ["show"]]);
         $this->middleware("permission:kelasperkuliahan-delete", ["only" => ["destroy"]]);
    }

    public function data()
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("kelasperkuliahan-edit");
            $canDelete = Gate::allows("kelasperkuliahan-delete");
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
                        return $data->nama_kelas.'-'.$data->kode;
                    })

                    ->addColumn('colors', function($data){
                        $input = '<div class="col" style="background-color:'.$data->color.'; height:10px"></div>';
                        return $input;
                    })



                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kelasperkuliahan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
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
        $canCreate = Gate::allows("kelasperkuliahan-create");
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $data = array(
            "page" => $name_page,
            "canCreate" => $canCreate,
            "title" => $title
        );
        return view("akademik::kelasperkuliahan.index")->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $matakuliah = MataKuliah::all();
        $jenissemester = JenisSemester::all();
        $typemahasiswa = TypeMahasiswa::all();
        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,
            "matakuliah"=>$matakuliah,
            "jenissemester" => $jenissemester,
            "typemahasiswa" => $typemahasiswa

        );

        return view("akademik::kelasperkuliahan.create")->with($data);
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
                "programstudy_id" => 'required',
                "semester_id" => 'required',
                "matakuliah_id" => 'required',
                "nama_kelas" => 'required',
                "jenis_kelas" => 'required',
                "type_mahasiswa" => 'required',
            ]);



            if($request->jumlah_generate_kelas != 0){
                for($i = 1; $i <= $request->jumlah_generate_kelas; $i++){
                    $kode = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                    $random = array_rand($kode,1);
                    $save = new KelasPerkuliahan();
                    $save->programstudy_id = $request->programstudy_id;
                    $save->semester_id = $request->semester_id;
                    $save->matakuliah_id = $request->matakuliah_id;
                    $save->nama_kelas = $request->nama_kelas;
                    $save->lingkup = $request->lingkup;
                    $save->mode_kuliah = $request->mode_kuliah;
                    $save->tanggal_mulai_kuliah = $request->tanggal_mulai_kuliah;
                    $save->tanggal_akhir_kuliah = $request->tanggal_akhir_kuliah;
                    $save->jenis_kelas = $request->jenis_kelas;
                    $save->color = $request->color ?? '#000000';
                    $save->min_peserta = $request->min_peserta ?? 0;
                    $save->max_peserta = $request->max_peserta ?? 0;
                    $save->typemahasiswa_id = json_encode($request->type_mahasiswa) ?? null;
                    $save->kode = $kode[$random].$i;
                    $save->save();
                 }
            }else{
                $save = new KelasPerkuliahan();
                $save->programstudy_id = $request->programstudy_id;
                $save->semester_id = $request->semester_id;
                $save->matakuliah_id = $request->matakuliah_id;
                $save->nama_kelas = $request->nama_kelas;
                $save->lingkup = $request->lingkup;
                $save->mode_kuliah = $request->mode_kuliah;
                $save->tanggal_mulai_kuliah = $request->tanggal_mulai_kuliah;
                $save->tanggal_akhir_kuliah = $request->tanggal_akhir_kuliah;
                $save->jenis_kelas = $request->jenis_kelas;
                $save->color = $request->color ?? '#000000';
                $save->min_peserta = $request->min_peserta ?? 0;
                $save->max_peserta = $request->max_peserta ?? 0;
                $save->typemahasiswa_id = json_encode($request->type_mahasiswa) ?? null;
                $save->kode = NULL;
            }



            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("kelasperkuliahan.index")->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("kelasperkuliahan.index")->with(["error" => "Data Gagal Disimpan!"]);
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view("akademik::show");
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $kelasperkuliahan = KelasPerkuliahan::findOrFail($id);
        // dd(json_decode($kelasperkuliahan->typemahasiswa_id));
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $matakuliah = MataKuliah::all();
        $jenissemester = JenisSemester::all();
        $typemahasiswa = TypeMahasiswa::all();
        $data = array(
            "page" => $name_page,
            "matakuliah" => $matakuliah,
            "kelasperkuliahan" => $kelasperkuliahan,
            "title" => $title,
            "programstudy" => $programstudy,
            "jenissemester" => $jenissemester,
            "typemahasiswa" => $typemahasiswa

        );
        return view("akademik::kelasperkuliahan.edit")->with($data);
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $this->validate($request, [
                "programstudy_id" => 'required',
                "semester_id" => 'required',
                "matakuliah_id" => 'required',
                "nama_kelas" => 'required',
                "jenis_kelas" => 'required',
                "type_mahasiswa" => 'required',
            ]);

            $save = KelasPerkuliahan::findOrFail($id);
            $save->programstudy_id = $request->programstudy_id;
            $save->semester_id = $request->semester_id;
            $save->matakuliah_id = $request->matakuliah_id;
            $save->nama_kelas = $request->nama_kelas;
            $save->lingkup = $request->lingkup;
            $save->mode_kuliah = $request->mode_kuliah;
            $save->tanggal_mulai_kuliah = $request->tanggal_mulai_kuliah;
            $save->tanggal_akhir_kuliah = $request->tanggal_akhir_kuliah;
            $save->jenis_kelas = $request->jenis_kelas;
            $save->min_peserta = $request->min_peserta ?? 0;
            $save->max_peserta = $request->max_peserta ?? 0;
            $save->color = $request->color ?? "#000000";
            $save->typemahasiswa_id = json_encode($request->type_mahasiswa) ?? null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($save) {
                //redirect dengan pesan sukses
                return redirect()->route("kelasperkuliahan.index")->with(["success" => "Data Berhasil Diubah!"]);
            } else {
                //redirect dengan pesan error
                return redirect()->route("kelasperkuliahan.index")->with(["error" => "Data Gagal Diubah!"]);
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
           $delete =  KelasPerkuliahan::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("kelasperkuliahan.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("kelasperkuliahan.index")->with(["error" => "Data Gagal Dihapus!"]);
        }

    }

    // dosen perkuliahan

    public function dataDosenPerkuliahan($id)
    {
        try {

            $data = DosenPerkuliahan::with("Dosen","Substansi")->where('kelasperkuliahan_id',$id)->get();

            return DataTables::of($data)

                    ->addColumn("action", function ($data) {

                        $btn = "";
                        $url = route('kelasperkuliahan.editdosenperkuliahan',$data->id);


                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';



                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';



                        return $btn;
                    })
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

    // create dosen
    public function createDosenPerkuliahan($id)
    {
        $name_page = "kelasperkuliahan";
        $title = "Dosen Kelas Perkuliahan";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $matakuliah = MataKuliah::all();
        $jenissemester = JenisSemester::all();
        $dosen = DosenPenugasan::with('Dosen')->get();
        $substansi = SubstansiKuliah::all();

        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,
            "matakuliah"=>$matakuliah,
            "jenissemester" => $jenissemester,
            "dosen" => $dosen,
            "substansi" => $substansi,
            'id' => $id,

        );

        return view("akademik::kelasperkuliahan.createdosen")->with($data);
    }

    public function storeDosenPerkuliahan(Request $request)
    {

        DB::beginTransaction();
        try {

            $this->validate($request, [
                "dosen_id" => 'required',
                "bobot_sks" => 'required',
                "jumlah_rencana_pertemuan" => 'required',
                "jenis_evaluasi" => 'required'

            ]);

            $semesteraktif = JenisSemester::where('aktif',1)->latest()->first();

            $save = new DosenPerkuliahan();
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->dosen_id = $request->dosen_id;
            $save->bobot_sks = $request->bobot_sks;
            $save->jumlah_rencana_pertemuan = $request->jumlah_rencana_pertemuan;
            $save->jumlah_realisasi_pertemuan = $request->jumlah_realisasi_pertemuan;
            $save->jenis_evaluasi = $request->jenis_evaluasi;
            $save->Jenissemester_id = $semesteraktif->id ?? 0;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("kelasperkuliahan.edit",$save->kelasperkuliahan_id)->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("kelasperkuliahan.edit",$save->kelasperkuliahan_id)->with(["error" => "Data Gagal Disimpan!"]);
        }
    }

    public function editDosenPerkuliahan($id)
    {
        $dosenperkuliahan = DosenPerkuliahan::findOrFail($id);
        $name_page = "kelasperkuliahan";
        $title = "Kelas Perkuliahan";
        $programstudy = ProgramStudy::with("jenjang","jurusan")->get();
        $matakuliah = MataKuliah::all();
        $jenissemester = JenisSemester::all();
        $dosen = DosenPenugasan::with('Dosen')->get();
        $substansi = SubstansiKuliah::all();
        $data = array(
            "page" => $name_page,
            "title" => $title,
            "programstudy" => $programstudy,
            "matakuliah"=>$matakuliah,
            "jenissemester" => $jenissemester,
            "dosen" => $dosen,
            "substansi" => $substansi,
            'id' => $id,
            "dosenperkuliahan" => $dosenperkuliahan

        );
        return view("akademik::kelasperkuliahan.editdosen")->with($data);
    }

    public function updateDosenPerkuliahan(Request $request, $id)
    {

        DB::beginTransaction();
        try {

            $this->validate($request, [
                "dosen_id" => 'required',
                "bobot_sks" => 'required',
                "jumlah_rencana_pertemuan" => 'required',
                "jenis_evaluasi" => 'required'

            ]);

            $semesteraktif = JenisSemester::where('aktif',1)->latest()->first();
            $save = DosenPerkuliahan::findORFail($id);
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->dosen_id = $request->dosen_id;
            $save->bobot_sks = $request->bobot_sks;
            $save->jumlah_rencana_pertemuan = $request->jumlah_rencana_pertemuan;
            $save->jumlah_realisasi_pertemuan = $request->jumlah_realisasi_pertemuan;
            $save->jenis_evaluasi = $request->jenis_evaluasi;
            $save->Jenissemester_id = $semesteraktif->id ?? 0;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("kelasperkuliahan.edit",$save->kelasperkuliahan_id)->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("kelasperkuliahan.edit",$save->kelasperkuliahan_id)->with(["error" => "Data Gagal Disimpan!"]);
        }
    }

    public function destroyDosenPerkuliahan($id)
    {
        DB::beginTransaction();
        try {
           $delete =  DosenPerkuliahan::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->back()->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(["error" => "Data Gagal Dihapus!"]);
        }

    }







}
