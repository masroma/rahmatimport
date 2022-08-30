<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JenisSemester;
use App\Models\TahunAjaran;
use App\Models\ProgramStudy;
use App\Models\Jurusan;
use App\Models\KelasPerkuliahan;
use App\Models\Mahasiswa;
use App\Models\Krs;
use App\Models\Khs;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RekapitulasiController extends Controller
{
    use ValidatesRequests;
    function __construct()
    {
        $this->middleware('permission:rekappelaporan-view|rekappelaporan-show', ['only' => ['index', 'show']]);
        $this->middleware('permission:rekappelaporan-view', ['only' => ['index']]);
        $this->middleware('permission:rekappelaporan-show', ['only' => ['show']]);
    }

    public function index_rekappelaporan()
    {
        $semester = JenisSemester::with('Tahunajaran')->get();
        $jurusan = Jurusan::all();
        $form = [
            [
                "name" => "semester_id",
                "type" => "select",
                "relasi" => $semester ?? [],
                "col" => "s12",
                "data" => $this->rekappelaporan->semester_id ?? '',
                "placeholder" => "Jenis Semester",
                "value" => "nama"
            ],
            [
                "name" => "programstudy_id",
                "type" => "select",
                "relasi" => $jurusan ?? [],
                "col" => "s12",
                "data" => $this->rekappelaporan->programstudy_id ?? '',
                "placeholder" => "Program Study",
                "value" => "nama"
            ],
            [
                "name" => "format",
                "type" => "format",
                "col" => "s12",
                "data" => '',
                "placeholder" => "Format",
                "value" => "nama"
            ],
        ];
        $canCreate = Gate::allows('rekappelaporan-create');
        $name_page = "rekappelaporan";
        $title = "Rekap Pelaporan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form' => $form
        );
        return view('akademik::rekapitulasi.rekappelaporan.index')->with($data);
    }

    public function show_rekappelaporan()
    {
        $this->validate(request(), [
            'semester_id'=>'required'
        ]);
        $data = DB::select("
            SELECT CONCAT(b.tahun_ajaran,' ',a.jenis_semester)tahun_ajaran, a.id,
            IFNULL(b.mahasiswa_baru,0) mahasiswa_baru, IFNULL(c.kelas_perkuliahan,0)kelas_perkuliahan,
            IFNULL(d.jumlah_krs,0)jumlah_krs,IFNULL(e.aktifitas_kuliah,0)aktifitas_kuliah, IFNULL(f.nilai_angka,0)nilai_angka
            FROM jenis_semesters a
            JOIN tahun_ajarans b ON b.id = a.tahunajaran_id
            LEFT JOIN(
                SELECT SUM(pendaftar_daftar_ulang) mahasiswa_baru, semester_id
                FROM `pengaturan_periode_perkuliahans`
                WHERE programstudy_id like concat(:programstudy1,'%')
                GROUP BY semester_id
            ) b ON a.id = b.semester_id
            LEFT JOIN (
                SELECT COUNT(*) kelas_perkuliahan, semester_id
                FROM `kelas_perkuliahans`
                WHERE programstudy_id like concat(:programstudy2,'%')
                GROUP BY semester_id
            ) c ON a.id = c.semester_id
            LEFT JOIN(
                SELECT COUNT(*) jumlah_krs,jenissemester_id
                FROM krs a
                JOIN `mahasiswa_history_pendidikans` b ON a.mahasiswa_id = b.mahasiswa_id
                WHERE b.programstudy_id like concat(:programstudy3,'%')
                GROUP BY jenissemester_id
            )d ON a.id = d.jenissemester_id
            LEFT JOIN (
                SELECT COUNT(*) aktifitas_kuliah, semester_id
                FROM `aktivitas_kuliah_mahasiswas` a
                JOIN `mahasiswa_history_pendidikans` b ON a.mahasiswa_id = b.mahasiswa_id
                WHERE b.programstudy_id like concat(:programstudy4,'%')
                GROUP BY semester_id
            ) e ON a.id = e.semester_id
            LEFT JOIN (
                SELECT SUM(nilai_angka) nilai_angka,b.periode_pendaftaran
                FROM `nilai_perkuliahans` a
                JOIN `mahasiswa_history_pendidikans` b ON a.mahasiswa_id = b.mahasiswa_id
                WHERE b.programstudy_id like concat(:programstudy5,'%')
                GROUP BY b.periode_pendaftaran
            ) f ON a.id = f.periode_pendaftaran
            WHERE a.id = :periode
        ",[
            'programstudy1'=>request('programstudy_id')??'',
            'programstudy2'=>request('programstudy_id')??'',
            'programstudy3'=>request('programstudy_id')??'',
            'programstudy4'=>request('programstudy_id')??'',
            'programstudy5'=>request('programstudy_id')??'',
            'periode'=>request('semester_id')
        ]);
        $tahunAjaran = JenisSemester::with('Tahunajaran')->where('id', request('semester_id'))->first();
        $jurusan = Jurusan::where('id',request('programstudy_id'))->first();
        // dd($data);
        $data = [
            'main' => $data,
            'periode' => $tahunAjaran->Tahunajaran->tahun_ajaran.' '.$tahunAjaran->jenis_semester,
            'jurusan' => $jurusan->nama_jurusan??'Semua Jurusan'
        ];
        $this->exportView='akademik::rekapitulasi.rekappelaporan.preview';
        $this->filename = 'Rekap Pelaporan' . $tahunAjaran->Tahunajaran->tahun_ajaran.'-'.$tahunAjaran->jenis_semester;
        return $this->export('html', $data);
    }

    public function index_jumlahdosen()
    {
        $semester = JenisSemester::with('Tahunajaran')->get();
        $jurusan = Jurusan::all();
        $form = [
            [
                "name" => "tahun",
                "type" => "selecttahun",
                "relasi" => $semester ?? [],
                "col" => "s12",
                "data" => '',
                "placeholder" => "Pilih Tahun",
                "value" => "nama"
            ],
            [
                "name" => "format",
                "type" => "format",
                "col" => "s12",
                "data" => '',
                "placeholder" => "Format",
                "value" => "nama"
            ],
        ];
        $canCreate = Gate::allows('jumlahdosen-create');
        $name_page = "jumlahdosen";
        $title = "Rekap Pelaporan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form' => $form
        );
        return view('akademik::rekapitulasi.jumlahdosen.index')->with($data);
    }

    public function show_jumlahdosen()
    {
        $this->validate(request(), [
            'tahun' => 'required',
            'format' => 'required'
        ]);
        $explode = explode('/', request('tahun'));
        $data = DB::select("
        SELECT a.id,a.nama_jurusan,
        sum(case when c.status_pegawai ='homebase' then IFNULL(c.totalDosen,0) ELSE 0 END) AS home_base,
        sum(case when c.status_pegawai ='nonhomebase' then IFNULL(c.totalDosen,0) ELSE 0 END) AS non_home_base
        FROM jurusans a
        LEFT JOIN dosen_penugasans b ON a.id = b.jurusan_id
        LEFT JOIN
        (
            SELECT COUNT(*) totalDosen, status_pegawai, id
            FROM dosen_details
            GROUP BY id, status_pegawai
        ) c ON c.id = b.dosen_id

        WHERE year(b.tanggal_surat_tugas) between :start_periode AND :end_periode
        ", ['start_periode' => $explode[0], 'end_periode' => $explode[1]]);
        $data = [
            'main' => $data,
            'tahun' => request('tahun')
        ];
        // dd($tahunAjaran);
        $this->exportView = 'akademik::rekapitulasi.jumlahdosen.preview';
        $this->filename = 'Jumlah-dosen-' . request('tahun');
        return $this->export(request('format'), $data);
    }

    public function index_jumlahmahasiswa()
    {
        $semester = JenisSemester::with('Tahunajaran')->get();
        $jurusan = Jurusan::all();
        $form = [
            [
                "name" => "semester_id",
                "type" => "select",
                "relasi" => $semester ?? [],
                "col" => "s12",
                "data" => $this->jumlahmahasiswa->semester_id ?? '',
                "placeholder" => "Jenis Semester",
                "value" => "nama"
            ],
            [
                "name" => "format",
                "type" => "format",
                "col" => "s12",
                "data" => '',
                "placeholder" => "Format",
                "value" => "nama"
            ],
        ];
        $canCreate = Gate::allows('jumlahmahasiswa-create');
        $name_page = "jumlahmahasiswa";
        $title = "Rekap Pelaporan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form' => $form
        );
        return view('akademik::rekapitulasi.jumlahmahasiswa.index')->with($data);
    }

    public function show_jumlahmahasiswa()
    {
        $this->validate(request(), [
            'semester_id' => 'required',
            'format' => 'required'
        ]);
        $data = DB::select("
        SELECT
        b.programstudy_id, c.nama_jurusan,
        sum(case when d.status_id =1 then IFNULL(d.totalSts,0) ELSE 0 END) AS aktif,
        sum(case when d.status_id =2 then IFNULL(d.totalSts,0) ELSE 0 END) AS cuti,
        sum(case when d.status_id =3 then IFNULL(d.totalSts,0) ELSE 0 END) AS kampus_merdeka,
        sum(case when d.status_id =4 then IFNULL(d.totalSts,0) ELSE 0 END) AS non_aktif,
        sum(case when d.status_id =5 then IFNULL(d.totalSts,0) ELSE 0 END) AS double_degree
        FROM jurusans c
        JOIN mahasiswa_history_pendidikans b ON b.programstudy_id = c.id
        LEFT JOIN
        (
        SELECT COUNT(status_id)AS totalSts, mahasiswa_id,status_id
        FROM aktivitas_kuliah_mahasiswas
        GROUP BY mahasiswa_id,status_id
        )d ON b.mahasiswa_id = d.mahasiswa_id
        WHERE b.periode_pendaftaran=:periode_pedaftaran
        ", ['periode_pedaftaran' => request('semester_id')]);
        $tahunAjaran = JenisSemester::with('Tahunajaran')->where('id', request('semester_id'))->first();
        $data = [
            'main' => $data,
            'semester' => $tahunAjaran
        ];
        // dd($tahunAjaran);
        $this->exportView = 'akademik::rekapitulasi.jumlahmahasiswa.preview';
        $this->filename = 'Jumlah-mahasiswa-' . $tahunAjaran->jenis_semester . '-' . $tahunAjaran->Tahunajaran->tahun_ajaran;
        return $this->export(request('format'), $data);
    }

    public function index_laporanstatusmahasiswa()
    {
        $semester = JenisSemester::with('Tahunajaran')->get();
        $jurusan = Jurusan::all();
        $form = [
            [
                "name" => "angkatan",
                "type" => "angkatan",
                "relasi" => '',
                "col" => "s12",
                "data" => '',
                "placeholder" =>"Angkatan",
                "value" =>"nama"
            ],
            [
                "name" => "programstudy_id",
                "type" => "select",
                "relasi" => $jurusan??[],
                "col" => "s12",
                "data" => '',
                "placeholder" =>"Program Study",
                "value" =>"nama"
            ],
            [
                "name" => "selectsortbymahasiswa",
                "type" => "selectsortbymahasiswa",
                "relasi" => '',
                "col" => "s12",
                "data" => '',
                "placeholder" =>"Short By",
                "value" =>"nama"
            ],
            [
                "name" => "format",
                "type" => "format",
                "col" => "s12",
                "data" => '',
                "placeholder" =>"Format",
                "value" =>"nama"
            ],
        ];
        $canCreate = Gate::allows('laporanstatusmahasiswa-create');
        $name_page = "laporanstatusmahasiswa";
        $title = "Rekap Pelaporan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form'=>$form
        );
        return view('akademik::rekapitulasi.laporanstatusmahasiswa.index')->with($data);
    }

    public function show_laporanstatusmahasiswa()
    {
        $this->validate(request(), [
            'angkatan'=>'required',
            'format'=>'required',
            'selectsortbymahasiswa'=>'required',
            'sorttype'=>'required',
        ]);
        $explode = explode('/',request('angkatan'));
        $data =DB::select("
        SELECT a.nama,b.nim, b.periode_pendaftaran,b.tanggal_masuk,c.status_mahasiswa AS last_sts,
        d.status_id,UPPER(LEFT(e.status_mahasiswa,1))status_mahasiswa,CONCAT(LEFT(b.tanggal_masuk,4),f.id) periode_masuk,CONCAT(LEFT(h.tahun_ajaran,4),f.id)periode_left
        FROM mahasiswas a
        JOIN mahasiswa_history_pendidikans b ON a.id = b.mahasiswa_id
        JOIN tahun_ajarans g ON g.id = b.periode_pendaftaran

        JOIN jenis_semesters f ON f.tahunajaran_id = g.id
        JOIN (
            SELECT mahasiswa_id,b.status_mahasiswa
            FROM aktivitas_kuliah_mahasiswas a
            JOIN status_mahasiswas b ON a.status_id = b.id
            ORDER BY a.created_at DESC LIMIT 1
        ) c ON c.mahasiswa_id = a.id
        JOIN aktivitas_kuliah_mahasiswas d ON d.mahasiswa_id = a.id
        JOIN tahun_ajarans h ON h.id = d.semester_id
        JOIN status_mahasiswas e ON d.status_id = e.id
        WHERE LEFT(h.tahun_ajaran,4) between :start_periode AND :end_periode order by ".request('selectsortbymahasiswa')." ".request('sorttype')
        ,['start_periode'=>$explode[0],'end_periode'=>$explode[1]]);
        $tahunAjaran = JenisSemester::with('Tahunajaran')->where('id',request('semester_id'))->first();
        $data = [
            'main'=>$data,
            'angkatan'=>request('angkatan')
        ];

        // dd($tahunAjaran);
        $this->exportView='akademik::rekapitulasi.laporanstatusmahasiswa.preview';
        $this->filename = 'status-mahasiswa-'.request('angkatan');
        return $this->export(request('format'),$data);
    }

    public function export($format,$data)
    {
        if(isset($data['main'])){
            if(count($data['main'])<=0){
                return redirect()->back()->with(["error" => "Data tidak ditemukan!"]);
            }
        }
        $filename = $this->filename;;
        if ( $format == 'html' ) {



            return view($this->exportView, $data);
        } else if ($format == 'docx') {

            $headers = array(
                "Content-type" => "text/html",
                "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
            );

            return \Response::make(view($this->exportView, $data), 200, $headers);
        } else if ($format == 'xlsx') {
            $headers = array(
                "Content-type" => "text/html",
                "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
            );

            return \Response::make(view($this->exportView, $data), 200, $headers);
        }
        return;
    }

    public function krsmahasiswa()
    {

        $mahasiswa = Mahasiswa::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "KRS Mahasiswa",
                "value" => ""
            ],
            1 => [
                "name" => "mahasiswa_id",
                "type" => "select",
                "relasi" => $mahasiswa,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Mahasiswa",
                "value" => "nama"
            ],
            2 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            3 => [
                "name" => "format",
                "type" => "selectformat",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Format",
                "value" => ""
            ],
        ];

        $name_page = "krsmahasiswa";
        $title = "KRS Mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'mahasiswa' => $mahasiswa,
            'jenis' => $jenis,
        );

        return view('akademik::rekapitulasi.krs.index')->with($data);
    }

    public function krsmahasiswastore(Request $request)
    {


        $this->validate($request, [
            "semester_id" => 'required',
            "mahasiswa_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $mahasiswa_id = $request->mahasiswa_id;
        $format = $request->format;

        $selKRSMahasiswa = Krs::select('mahasiswas.nim', 'mahasiswas.nama', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mata_kuliahs.kode_matakuliah', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'nilai_perkuliahans.nilai_angka', 'nilai_perkuliahans.nilai_huruf', 'skala_nilais.nilai_index')
            ->leftjoin('mahasiswas', 'mahasiswas.id', 'krs.mahasiswa_id')
            ->leftjoin('mata_kuliahs', 'mata_kuliahs.id', 'krs.matakuliah_id')
            ->leftjoin('kelas_perkuliahans', 'kelas_perkuliahans.id', 'krs.kelas_id')
            ->leftjoin('program_studies', 'program_studies.id', 'kelas_perkuliahans.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'krs.jenissemester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin('nilai_perkuliahans', function ($join) {
                $join->on('nilai_perkuliahans.kelas_id', '=', 'krs.kelas_id')
                    ->on('nilai_perkuliahans.mahasiswa_id', '=', 'krs.mahasiswa_id');
            })
            ->leftjoin('skala_nilais', function ($join) {
                $join->on('skala_nilais.programstudy_id', '=', 'kelas_perkuliahans.programstudy_id')
                    ->on('skala_nilais.nilai_huruf', '=', 'nilai_perkuliahans.nilai_huruf');
            })
            ->where('krs.jenissemester_id', $semester_id)
            ->where('mahasiswas.id', $mahasiswa_id)
            ->orderBy('krs.id', 'ASC')
            ->get();
        if (count($selKRSMahasiswa) <= 0) {
            return redirect()->back()->with(["error" => "Data tidak ditemukan!"]);
        }
        $this->exportView = 'akademik::rekapitulasi.krs.preview';
        $this->filename = "KRS_Mahasiswa" . $selKRSMahasiswa[0]->tahun_ajaran . "-" . $selKRSMahasiswa[0]->jenis_semester;
        $data = [
            'main' => $selKRSMahasiswa,
        ];
        return $this->export(request('format'), $data);
    }
    public function khsmahasiswa()
    {

        $mahasiswa = Mahasiswa::all();

        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "KHS Mahasiswa",
                "value" => ""
            ],
            1 => [
                "name" => "mahasiswa_id",
                "type" => "select",
                "relasi" => $mahasiswa,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Mahasiswa",
                "value" => "nama"
            ],
            2 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            3 => [
                "name" => "format",
                "type" => "selectformat",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Format",
                "value" => ""
            ],
        ];

        $name_page = "khsmahasiswa";
        $title = "KHS Mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'mahasiswa' => $mahasiswa,
            'jenis' => $jenis,
        );

        return view('akademik::rekapitulasi.khs.index')->with($data);
    }

    public function khsmahasiswastore(Request $request)
    {

        $this->validate($request, [
            "semester_id" => 'required',
            "mahasiswa_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $mahasiswa_id = $request->mahasiswa_id;
        $format = $request->format;

        $selKHSMahasiswa = Krs::select('mahasiswas.nim', 'mahasiswas.nama', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mata_kuliahs.kode_matakuliah', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'nilai_perkuliahans.nilai_angka', 'nilai_perkuliahans.nilai_huruf', 'skala_nilais.nilai_index')
            ->leftjoin('mahasiswas', 'mahasiswas.id', 'krs.mahasiswa_id')
            ->leftjoin('mata_kuliahs', 'mata_kuliahs.id', 'krs.matakuliah_id')
            ->leftjoin('kelas_perkuliahans', 'kelas_perkuliahans.id', 'krs.kelas_id')
            ->leftjoin('program_studies', 'program_studies.id', 'kelas_perkuliahans.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'krs.jenissemester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin('nilai_perkuliahans', function ($join) {
                $join->on('nilai_perkuliahans.kelas_id', '=', 'krs.kelas_id')
                    ->on('nilai_perkuliahans.mahasiswa_id', '=', 'krs.mahasiswa_id');
            })
            ->leftjoin('skala_nilais', function ($join) {
                $join->on('skala_nilais.programstudy_id', '=', 'kelas_perkuliahans.programstudy_id')
                    ->on('skala_nilais.nilai_huruf', '=', 'nilai_perkuliahans.nilai_huruf');
            })
            ->where('krs.jenissemester_id', $semester_id)
            ->where('mahasiswas.id', $mahasiswa_id)
            ->orderBy('krs.id', 'ASC')
            ->get();
        if (count($selKHSMahasiswa) <= 0) {
            return redirect()->back()->with(["error" => "Data tidak ditemukan!"]);
        }
        $this->exportView = 'akademik::rekapitulasi.khs.preview';
        $this->filename = "KHS_Mahasiswa" . $selKHSMahasiswa[0]->tahun_ajaran . "-" . $selKHSMahasiswa[0]->jenis_semester;
        return $this->export(request('format'), ['selKHSMahasiswa'=>$selKHSMahasiswa]);
    }

    public function index_sksdosenmengajar()
    {
        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
             [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
            ],
            [
                "name" => "format",
                "type" => "format",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => '',
                "placeholder" => "Format",
                "value" => "nama"
            ],
        ];
        $canCreate = Gate::allows('sksdosenmengajar-create');
        $name_page = "sksdosenmengajar";
        $title = "sks dosen mengajar";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form' => $form,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );
        return view('akademik::rekapitulasi.sksdosenmengajar.index')->with($data);
    }

    public function show_sksdosenmengajar(Request $request)
    {
        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;


        $selKP = KelasPerkuliahan::select('jenjang_pendidikans.nama_jenjang', 'jurusans.nama_jurusan', 'mata_kuliahs.kode_matakuliah','mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'dosen_perkuliahans.bobot_sks', 'kelas_perkuliahans.nama_kelas', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester' )
            ->leftjoin('dosen_perkuliahans', 'dosen_perkuliahans.kelasperkuliahan_id', 'kelas_perkuliahans.id')
            ->leftjoin('mata_kuliahs', 'mata_kuliahs.id', 'kelas_perkuliahans.matakuliah_id')
            ->leftjoin('program_studies', 'program_studies.id', 'kelas_perkuliahans.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'kelas_perkuliahans.semester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin(DB::raw('( SELECT count(id) jumlah_krs,kelas_id,matakuliah_id,jenissemester_id FROM krs GROUP BY kelas_id,matakuliah_id,jenissemester_id ) countkrs'),
            function($join)
            {
            $join->on('kelas_perkuliahans.id', '=', 'countkrs.kelas_id');
            $join->on('kelas_perkuliahans.matakuliah_id', '=', 'countkrs.matakuliah_id');
            $join->on('kelas_perkuliahans.semester_id', '=', 'countkrs.jenissemester_id');
            })
            ->where('kelas_perkuliahans.semester_id', $semester_id)
            ->where('kelas_perkuliahans.programstudy_id', $programstudy_id)
            ->orderBy('kelas_perkuliahans.id', 'ASC')
            ->get();

            if (count($selKP) <= 0) {
                return redirect()->back()->with(["error" => "Data tidak ditemukan!"]);
            }
            $data = [
                'selKP' => $selKP,
                'format' => $format
            ];
            $this->exportView = 'akademik::rekapitulasi.sksdosenmengajar.preview';
            $this->filename = "SKS_DOSEN_MENGAJAR" . $selKP[0]->tahun_ajaran . "-" . $selKP[0]->jenis_semester;
            return $this->export($format, $data);
    }
    public function index_ipsmahasiswa()
    {
        $semester = JenisSemester::with('Tahunajaran')->get();
        $jurusan = Jurusan::all();
        $form = [
            [
                "name" => "tahun",
                "type" => "selecttahun",
                "relasi" => $semester ?? [],
                "col" => "s12",
                "data" => '',
                "placeholder" => "Pilih Tahun",
                "value" => "nama"
            ],
            [
                "name" => "format",
                "type" => "format",
                "col" => "s12",
                "data" => '',
                "placeholder" => "Format",
                "value" => "nama"
            ],
        ];
        $canCreate = Gate::allows('ipsmahasiswa-create');
        $name_page = "ipsmahasiswa";
        $title = "Rekap Pelaporan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form' => $form
        );
        return view('akademik::rekapitulasi.ipsmahasiswa.index')->with($data);
    }

    public function show_ipsmahasiswa()
    {
        $this->validate(request(), [
            'tahun' => 'required',
            'format' => 'required'
        ]);
        $explode = explode('/', request('tahun'));
        $data = DB::select("
        SELECT a.nama_jurusan,
        COUNT(CASE WHEN c.ips >=0 AND c.ips <=0 THEN c.ips END)ips_01,
        COUNT(CASE WHEN c.ips >=1 AND c.ips <=2 THEN c.ips END)ips_12,
        COUNT(CASE WHEN c.ips >=2 AND c.ips <=3 THEN c.ips END)ips_23,
        COUNT(CASE WHEN c.ips >=3 AND c.ips <=4 THEN c.ips END)ips_34,
        COUNT(CASE WHEN c.ips >4 THEN c.ips END)ips_4,
        a.id
        FROM jurusans a
        LEFT JOIN mahasiswa_history_pendidikans b ON b.programstudy_id = a.id
        LEFT JOIN aktivitas_kuliah_mahasiswas c ON c.mahasiswa_id = b.mahasiswa_id
        LEFT JOIN tahun_ajarans d ON d.id = b.periode_pendaftaran
        WHERE d.tahun_ajaran = :tahun
        GROUP BY  a.id
        ", ['tahun' => request('tahun')]);
        $data = [
            'main' => $data,
            'tahun' => request('tahun')
        ];
        $this->exportView = 'akademik::rekapitulasi.ipsmahasiswa.preview';
        $this->filename = 'Jumlah-dosen-' . request('tahun');
        return $this->export(request('format'), $data);
    }
}
