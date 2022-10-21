<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasMahasiswa;
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
use App\Models\NilaiKampusMerdeka;
use App\Models\MataKuliah;
use App\Models\MahasiswaHistoryPendidikan;
use App\Models\SkalaNilai;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KonversiKampusMedekaController extends Controller
{
    use ValidatesRequests;
    function __construct()
    {
         $this->middleware('permission:konversikampusmerdeka-view|konversikampusmerdeka-create|konversikampusmerdeka-edit|konversikampusmerdeka-show|konversikampusmerdeka-delete', ['only' => ['index','store']]);
         $this->middleware('permission:konversikampusmerdeka-view', ['only' => ['index']]);
         $this->middleware('permission:konversikampusmerdeka-create', ['only' => ['create','store']]);
         $this->middleware('permission:konversikampusmerdeka-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:konversikampusmerdeka-show', ['only' => ['show']]);
         $this->middleware('permission:konversikampusmerdeka-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('konversikampusmerdeka-edit');
            $canDelete = Gate::allows('konversikampusmerdeka-delete');
            $data = AktivitasMahasiswa::where('jenisaktivitas_id',5)->get();
            return DataTables::of($data)
                    ->addColumn('programstudy', function($data){
                        return $data->ProgramStudy->jurusan->nama_jurusan ;
                    })
                    ->addColumn('semester', function($data){
                        return $data->Semester->Tahunajaran->tahun_ajaran .'-'. $data->Semester->jenis_semester;
                    })
                    ->addColumn('jenisaktivitas', function($data){
                        return $data->JenisAktivitas->jenis_aktivitas;
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canShow) {

                        $btn = '';
                        $url = route('konversikampusmerdeka.edit',$data->id);

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating btn-small purple " href="'.$url.'"><i class="material-icons">view_headline</i></a>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="konversikampusmerdeka/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('konversikampusmerdeka-create');
        $name_page = "konversikampusmerdeka";
        $title = "aktivitas mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::konversikampusmerdeka.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $programstudy = ProgramStudy::all();
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

        $name_page = "konversikampusmerdeka";
        $title = "aktivitas mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy'=>$programstudy,
            'jenisaktivitas'=>$jenisaktivitas,
            'jenis' =>$jenis
        );

        return view('akademik::konversikampusmerdeka.create')->with($data);
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
            return redirect()->route('konversikampusmerdeka.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('konversikampusmerdeka.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $semester = JenisSemester::orderBy('id','DESC')->pluck('id')->first();
        $aktivitas = AktivitasMahasiswa::where('jenisaktivitas_id',5)->findOrFail($id);
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

        $name_page = "konversikampusmerdeka";
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
        return view('akademik::konversikampusmerdeka.edit')->with($data);
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
            // $canUpdate = Gate::allows('konversikampusmerdeka-edit');
            // $canDelete = Gate::allows('konversikampusmerdeka-delete');
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


                    ->addColumn('action', function ($data) use ($id) {

                        $btn = '';


                            $btn .= '<a class="btn-floating purple darken-1 btn-small" href="'.url('akademik/konversikampusmerdeka/datapesertaaktif/detail/').'/'.$id.'/'.$data->mahasiswa->id.'"><i class="material-icons">view_headline</i></button>';


                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="konversikampusmerdeka/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
    public function detailPesertaAktif($id,$mahasiswa_id)
    {
        // dd('ee');
        $aktivitas = PesertaAktivitas::with(['Mahasiswa','aktivitas_mahasiswa'=>function($q){
            $q->with(['Semester'=>function($d){
                $d->with('Tahunajaran');
            },'JenisAktivitas']);
        }])
        ->whereHas('Mahasiswa',function($a) use($mahasiswa_id){
            $a->where('id',$mahasiswa_id);
        })->where('aktivitasmahasiswa_id',$id)->first();

        $programstudy = MahasiswaHistoryPendidikan::where('mahasiswa_id',$mahasiswa_id)->pluck('programstudy_id')->first();

        $matakuliah = Matakuliah::where(['programstudy_id'=>$programstudy])->get();
        $skalaNilai = SkalaNilai::where(['programstudy_id'=>$programstudy])->get();
        $name_page = "konversikampusmerdeka";
        $title = "aktivitas mahasiswa";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'aktivitas'=>$aktivitas,
            'matakuliah'=>$matakuliah,
            'skalaNilai'=>$skalaNilai
        );
        // dd($aktivitas);
        return view('akademik::konversikampusmerdeka.nilai')->with($data);
    }

    public function detailNilaiKampusMerdeka($id,$mahasiswa_id)
    {
        $canUpdate = Gate::allows('skalanilai-edit');
            $canDelete = Gate::allows('skalanilai-delete');
        try {
            $nilaiaktivitas= NilaiKampusMerdeka::with(['mahasiswa','matakuliah','aktivitas_mahasiswa'])
            ->whereHas('mahasiswa',function($a) use($mahasiswa_id){
                $a->where('id',$mahasiswa_id);
            })->whereHas('aktivitas_mahasiswa',function($a) use($id){
                $a->where('id',$id);
            })->get();
            return DataTables::of($nilaiaktivitas)

                    ->addColumn('action', function ($data) use ($id, $canDelete) {

                        $btn = '';

                        if ($canDelete) {
                            $btn .= '<a class="btn-floating red darken-1 btn-small" href="#" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }


                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="konversikampusmerdeka/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
    public function storeNilaiKampusMerdeka(Request $request)
    {
        $this->validate($request, [
            'aktivitas_id'=>'required',
            'matakuliah_id'=>'required',
            'mahasiswa_id'=>'required',
            'nilai_angka'=>'required',
            'nilai_huruf'=>'required'
        ]);
        DB::beginTransaction();
        try {
            $nilaiKampusMerdeka = new NilaiKampusMerdeka();
            $params = array_filter(request()->all(),function($key) use ($nilaiKampusMerdeka){
                return in_array($key,$nilaiKampusMerdeka->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            $params['index']=explode('-',$params['nilai_huruf'])[1];
            $params['nilai_huruf']=explode('-',$params['nilai_huruf'])[0];

            $save = NilaiKampusMerdeka::create($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function destroyNilai($id)
    {
        NilaiKampusMerdeka::find($id)->delete();
        return redirect()->back()
            ->with('success', 'Data berhasil dihapus');
    }

}
