<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasKuliahMahasiswa;
use App\Models\JenisAktivitas;
use App\Models\JenisSemester;
use App\Models\ProgramStudy;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\KategoriKegiatan;
use App\Models\PesertaAktivitas;
use App\Models\DosenPembimbingAktivitasMahasiswa;
use App\Models\DosenPengujiAktivitasMahasiswa;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AktivitasMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:aktivitasmahasiswa-view|aktivitasmahasiswa-create|aktivitasmahasiswa-edit|aktivitasmahasiswa-show|aktivitasmahasiswa-delete', ['only' => ['index','store']]);
         $this->middleware('permission:aktivitasmahasiswa-view', ['only' => ['index']]);
         $this->middleware('permission:aktivitasmahasiswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:aktivitasmahasiswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:aktivitasmahasiswa-show', ['only' => ['show']]);
         $this->middleware('permission:aktivitasmahasiswa-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('aktivitasmahasiswa-edit');
            $canDelete = Gate::allows('aktivitasmahasiswa-delete');
            $data = AktivitasMahasiswa::all();
            return DataTables::of($data)
                    ->addColumn('programstudy', function($data){
                        return $data->ProgramStudy->jurusan->nama_jurusan ;
                    })
                    ->addColumn('semester', function($data){
                        foreach($data->Semester->tahun_ajarans as $ta) {
                            $var_ta = $ta->tahun_ajaran;
                            return $var_ta ."-" . $data->Semester->jenis_semester;
                        }
                    })
                    ->addColumn('jenisaktivitas', function($data){
                        return $data->JenisAktivitas->jenis_aktivitas;
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';
                        $url = route('aktivitasmahasiswa.edit',$data->id);

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitasmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        // $datas = AktivitasMahasiswa::with('Programstudy');
        // 
        // $datas = AktivitasMahasiswa::all();
        // dd($datas);
        $canCreate = Gate::allows('aktivitasmahasiswa-create');
        $name_page = "aktivitasmahasiswa";
        $title = "aktivitas mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::aktivitasmahasiswa.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        $programstudy = ProgramStudy::all();
        //dd($programstudy);
        $jenisaktivitas = JenisAktivitas::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Program Study",
                "value" =>"programstudy"
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
                "name" => "no_sk_tugas",
                "type" => "text",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"No SK Tugas"
            ],

            3 => [
                "name" => "tanggal_sk_tugas",
                "type" => "date",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Tanggal SK Tugas",
            ],
            4 => [
                "name" => "jenisaktivitas_id",
                "type" => "select",
                "relasi" => $jenisaktivitas,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Jenis Aktivitas",
                "value" =>"jenis_aktivitas"
            ],
            5 => [
                "name" => "jenis_anggota",
                "type" => "selectanggota",
                "relasi" => "",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Jenis Anggota",
                "value" =>""
            ],
            6 => [
                "name" => "judul",
                "type" => "textarea",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Judul",
            ],
            7 => [
                "name" => "keterangan",
                "type" => "textarea",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Keterangan",
            ],
            8 => [
                "name" => "lokasi",
                "type" => "text",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"Lokasi",
            ],
        ];

        $name_page = "aktivitasmahasiswa";
        $title = "aktivitas mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy'=>$programstudy,
            'jenisaktivitas'=>$jenisaktivitas,
            'jenis' =>$jenis
        );

        return view('akademik::aktivitasmahasiswa.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'programstudy_id' => 'required',
                'semester_id' => 'required',
                'no_sk_tugas' => 'required',
                'tanggal_sk_tugas' => 'required',
                'jenisaktivitas_id' => 'required',
                'jenis_anggota' => 'required',
                'judul' => 'required',
                // 'keterangan' => 'required',
                'lokasi' => 'required'
            ]);

            $save = new AktivitasMahasiswa();
            $save->programstudy_id = $request->programstudy_id;
            $save->semester_id = $request->semester_id;
            $save->no_sk_tugas = $request->no_sk_tugas;
            $save->tanggal_sk_tugas = date("Y-m-d",strtotime($request->tanggal_sk_tugas));
            $save->jenisaktivitas_id = $request->jenisaktivitas_id;
            $save->jenis_anggota = $request->jenis_anggota;
            $save->judul = $request->judul;
            $save->keterangan = $request->keterangan ?? "&nbsp;";
            $save->lokasi = $request->lokasi;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('aktivitasmahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('aktivitasmahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $aktivitas = AktivitasMahasiswa::findOrFail($id);
        $programstudy = ProgramStudy::all();
        $jenisaktivitas = JenisAktivitas::all();
        $jenis = JenisSemester::all();
        $mahasiswa = Mahasiswa::all();
        $Dosen = Dosen::all();
        $KategoriKegiatan = KategoriKegiatan::all();
        $form = [
            0 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s6",
                "data" => $aktivitas->programstudy_id,
                "placeholder" =>"Program Study",
                "value" =>"programstudy"
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
                "name" => "no_sk_tugas",
                "type" => "text",
                "col" => "s6",
                "data" => $aktivitas->no_sk_tugas,
                "placeholder" =>"No SK Tugas"
            ],

            3 => [
                "name" => "tanggal_sk_tugas",
                "type" => "date",
                "col" => "s6",
                "data" => $aktivitas->tanggal_sk_tugas,
                "placeholder" =>"Tanggal SK Tugas",
            ],
            4 => [
                "name" => "jenisaktivitas_id",
                "type" => "select",
                "relasi" => $jenisaktivitas,
                "col" => "s6",
                "data" => $aktivitas->jenisaktivitas_id,
                "placeholder" =>"Jenis Aktivitas",
                "value" =>"jenis_aktivitas"
            ],
            5 => [
                "name" => "jenis_anggota",
                "type" => "selectanggota",
                "relasi" => "",
                "col" => "s6",
                "data" => $aktivitas->jenis_anggota,
                "placeholder" =>"Jenis Anggota"
            ],
            6 => [
                "name" => "judul",
                "type" => "textarea",
                "col" => "s6",
                "data" => $aktivitas->judul,
                "placeholder" =>"Judul",
            ],
            7 => [
                "name" => "keterangan",
                "type" => "textarea",
                "col" => "s6",
                "data" => $aktivitas->keterangan,
                "placeholder" =>"Keterangan",
            ],
            8 => [
                "name" => "lokasi",
                "type" => "text",
                "col" => "s6",
                "data" => $aktivitas->lokasi,
                "placeholder" =>"Lokasi",
            ],
        ];

        $name_page = "aktivitasmahasiswa";
        $title = "aktivitas mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy'=>$programstudy,
            'jenisaktivitas'=>$jenisaktivitas,
            'jenis' =>$jenis,
            'aktivitas'=>$aktivitas,
            'mahasiswa' => $mahasiswa,
            'dosen' => $Dosen,
            'kategorikegiatan' => $KategoriKegiatan
        );
        return view('akademik::aktivitasmahasiswa.edit')->with($data);
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
                'programstudy_id' => 'required',
                'semester_id' => 'required',
                'no_sk_tugas' => 'required',
                'tanggal_sk_tugas' => 'required',
                'jenisaktivitas_id' => 'required',
                'jenis_anggota' => 'required',
                'judul' => 'required',
                'keterangan' => 'required',
                'lokasi' => 'required'
            ]);

            $save = AktivitasMahasiswa::findOrFail($id);
            $save->programstudy_id = $request->programstudy_id;
            $save->semester_id = $request->semester_id;
            $save->no_sk_tugas = $request->no_sk_tugas;
            $save->tanggal_sk_tugas = date("Y-m-d",strtotime($request->tanggal_sk_tugas));
            $save->jenisaktivitas_id = $request->jenisaktivitas_id;
            $save->jenis_anggota = $request->jenis_anggota;
            $save->judul = $request->judul;
            $save->keterangan = $request->keterangan;
            $save->lokasi = $request->lokasi;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('aktivitasmahasiswa.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('aktivitasmahasiswa.index')->with(['error' => 'Data Gagal Diubah!']);
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
           $delete =  AktivitasMahasiswa::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("aktivitasmahasiswa.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("aktivitasmahasiswa.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }

    public function cekSubmit(Request $request){

        if($request->type == "peserta") {
           return  $this->addPesertaAktif($request);

        }else if($request->type == "pembimbing"){
            return $this->addPembimbingAktivitasMahasiswa($request);

        }else if($request->type == "penguji"){
            return $this->addPengujiAktivitasMahasiswa($request);

        }
    }
    // peserta aktif
    public function dataPesertaAktif($id)
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            // $canUpdate = Gate::allows('aktivitasmahasiswa-edit');
            // $canDelete = Gate::allows('aktivitasmahasiswa-delete');
            $data = PesertaAktivitas::with('Mahasiswa')->where('aktivitasmahasiswa_id',$id)->get();
            return DataTables::of($data)
                    ->addColumn('peranpeserta', function($data){
                        $peran = "";
                        if($data->peranpeserta_id == "1"){
                            $peran = "1 - Ketua";
                        }elseif($data->peranpeserta_id == "2"){
                            $peran = "2 - Anggota";
                        }elseif($data->peranpeserta_id == "3"){
                            $peran = "3 - Personal";
                        }

                        return $peran;
                    })


                    ->addColumn('action', function ($data)  {

                        $btn = '';


                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirmPeserta('.$data->id.')"><i class="material-icons">delete</i></button>';


                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitasmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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

    public function addPesertaAktif(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'mahasiswa_id' => 'required',
                'peranpeserta_id' => 'required',
            ]);

            $save = new PesertaAktivitas();
            $save->aktivitasmahasiswa_id = $request->aktivitasmahasiswa_id;
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->peranpeserta_id = $request->peranpeserta_id;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Diubah!']);
        }
    }

    public function destroyPeserta($id)
    {
        DB::beginTransaction();
        try {
           $delete =  PesertaAktivitas::find($id)->delete();
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

    // dosenpembimbing
    public function dataPembimbingAktivitasMahasiswa($id)
    {
        try {

            $data = DosenPembimbingAktivitasMahasiswa::with('Dosen','Kategorikegiatan')->where('aktivitasmahasiswa_id',$id)->get();
            return DataTables::of($data)

                    ->addColumn('action', function ($data)  {

                        $btn = '';


                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirmDospem('.$data->id.')"><i class="material-icons">delete</i></button>';


                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitasmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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

    public function addPembimbingAktivitasMahasiswa(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'dosen_id' => 'required',
                'order' => 'required',
                'kategorikegiatan_id' => 'required',
            ]);

            $save = new DosenPembimbingAktivitasMahasiswa();
            $save->aktivitasmahasiswa_id = $request->aktivitasmahasiswa_id;
            $save->dosen_id = $request->dosen_id;
            $save->order = $request->order;
            $save->kategorikegiatan_id = $request->kategorikegiatan_id;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Diubah!']);
        }
    }

    public function destroyPembimbingAktivitasMahasiswa($id)
    {
        DB::beginTransaction();
        try {
           $delete =  DosenPembimbingAktivitasMahasiswa::find($id)->delete();
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

    // penguji
    public function dataPengujiAktivitasMahasiswa($id)
    {
        try {

            $data = DosenPengujiAktivitasMahasiswa::with('Dosen','Kategorikegiatan')->where('aktivitasmahasiswa_id',$id)->get();
            return DataTables::of($data)

                    ->addColumn('action', function ($data)  {

                        $btn = '';


                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirmDospen('.$data->id.')"><i class="material-icons">delete</i></button>';


                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitasmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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

    public function addPengujiAktivitasMahasiswa(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'dosen_id' => 'required',
                'order' => 'required',
                'kategorikegiatan_id' => 'required',
            ]);

            $save = new DosenPengujiAktivitasMahasiswa();
            $save->aktivitasmahasiswa_id = $request->aktivitasmahasiswa_id;
            $save->dosen_id = $request->dosen_id;
            $save->order = $request->order;
            $save->kategorikegiatan_id = $request->kategorikegiatan_id;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Diubah!']);
        }
    }

    public function destroyPengujiAktivitasMahasiswa($id)
    {
        DB::beginTransaction();
        try {
           $delete =  DosenPengujiAktivitasMahasiswa::find($id)->delete();
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
