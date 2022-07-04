<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasKuliahMahasiswa;
use App\Models\Dosen;
use App\Models\DosenPerkuliahan;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Mahasiswa;
use App\Models\JenisSemester;
use App\Models\KelasPerkuliahan;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\ProgramStudy;
use App\Models\TahunAjaran;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ExportDataController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;


    function __construct()
    {

        $this->middleware("permission:exportdata-view|exportdata-create|exportdata-edit|exportdata-show|exportdata-delete", ["only" => ["index", "store"]]);
        $this->middleware("permission:exportdata-view", ["only" => ["index"]]);
        $this->middleware("permission:exportdata-create", ["only" => ["create", "store"]]);
        $this->middleware("permission:exportdata-edit", ["only" => ["edit", "update"]]);
        $this->middleware("permission:exportdata-show", ["only" => ["show"]]);
        $this->middleware("permission:exportdata-delete", ["only" => ["destroy"]]);
    }




    public function mahasiswa()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [

            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",

                "placeholder" => "Daftar Mahasiswa Per Tahuh Ajaran",
                "value" => ""
            ],

            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"

            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",

                "placeholder" => "Program Study",
                "value" => "programstudy"

            ],
            3 => [
                "name" => "sortbymahasiswa",
                "type" => "selectsortbymahasiswa",
                "relasi" => "",
                "col" => "",
                "data" => "",
                "placeholder" => "Urutkan Berdasarkan",
                "value" => ""
            ],
            4 => [
                "name" => "format",
                "type" => "selectformat",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",

                "placeholder" => "Format",
                "value" => ""

            ],
        ];

        $name_page = "mahasiswa";

        $title = "mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function mahasiswastore(Request $request)
    {



        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;



        $sortbymahasiswa =  '';
        if ($request->sortbymahasiswa == 'jenis_pendaftaran' || $request->sortbymahasiswa == 'programstudy_id') {
            $sortbymahasiswa =  'mahasiswa_history_pendidikans.' . $request->sortbymahasiswa;
        } else if ($request->sortbymahasiswa == 'status') {
            $sortbymahasiswa =  'aktivitas.' . $request->sortbymahasiswa . '_id';
        } else {
            $sortbymahasiswa =  'mahasiswas.' . $request->sortbymahasiswa;
        }
        $sorttype = $request->sorttype;
        $format = $request->format;

        $selMH = Mahasiswa::select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.jenis_kelamin',  'mahasiswas.tempat_lahir',  'mahasiswas.tanggal_lahir',  'mahasiswas.agama',  'mahasiswa_details.jalan',  'mahasiswa_details.ktp', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mahasiswa_history_pendidikans.tanggal_masuk', 'jenis_pendaftarans.jenis_pendaftaran', 'status_mahasiswas.status_mahasiswa', 'pembiayaan_awals.pembiayaan_awal')
            ->leftjoin('aktivitas_kuliah_mahasiswas', 'aktivitas_kuliah_mahasiswas.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'aktivitas_kuliah_mahasiswas.semester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin('status_mahasiswas', 'status_mahasiswas.id', 'aktivitas_kuliah_mahasiswas.status_id')
            ->leftjoin('mahasiswa_history_pendidikans', 'mahasiswa_history_pendidikans.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('mahasiswa_details', 'mahasiswa_details.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('pembiayaan_awals', 'pembiayaan_awals.id', 'mahasiswa_history_pendidikans.pembiayaan_awal')
            ->leftjoin('program_studies', 'program_studies.id', 'mahasiswa_history_pendidikans.programstudy_id')
            ->leftjoin('jenis_pendaftarans', 'jenis_pendaftarans.id', 'mahasiswa_history_pendidikans.jenis_pendaftaran')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->where('aktivitas_kuliah_mahasiswas.semester_id', $semester_id)
            ->where('mahasiswa_history_pendidikans.programstudy_id', $programstudy_id)
            ->orderBy($sortbymahasiswa, $sorttype)->get();

        if (count($selMH) > 0) {
            $filename = "Daftar_Mahasiswa_Per_Periode_" . $selMH[0]->tahun_ajaran . "-" . $selMH[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.mahasiswa', compact('selMH', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.mahasiswa', compact('selMH')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.mahasiswa', compact('selMH')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.mahasiswa")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function nilaitransfer()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar Nilai Transfer Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "nilaitransfer";
        $title = "nilai transfer";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function nilaitransferstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selMH = Mahasiswa::select('mahasiswas.nim', 'mahasiswas.nama', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'nilai_transfers.kode_mk_asal', 'nilai_transfers.sks_asal', 'nilai_transfers.nilai_huruf_asal', 'mk_asal.nama_matakuliah as nama_matakuliah_asal', 'mk_diakui.nama_matakuliah as nama_matakuliah', 'mk_diakui.kode_matakuliah', 'mk_diakui.bobot_mata_kuliah', 'nilai_transfers.nilai_huruf_diakui', 'nilai_perkuliahans.nilai_angka')
            ->leftjoin('aktivitas_kuliah_mahasiswas', 'aktivitas_kuliah_mahasiswas.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'aktivitas_kuliah_mahasiswas.semester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin('mahasiswa_history_pendidikans', 'mahasiswa_history_pendidikans.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('program_studies', 'program_studies.id', 'mahasiswa_history_pendidikans.programstudy_id')
            ->leftjoin('jenis_pendaftarans', 'jenis_pendaftarans.id', 'mahasiswa_history_pendidikans.jenis_pendaftaran')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->join('nilai_transfers', 'nilai_transfers.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('mata_kuliahs as mk_asal', 'mk_asal.id', 'nilai_transfers.matakuliah_asal')
            ->leftjoin('mata_kuliahs as mk_diakui', 'mk_diakui.id', 'nilai_transfers.matakuliah_diakui')
            ->leftjoin('kelas_perkuliahans', function ($join) {
                $join->on('kelas_perkuliahans.programstudy_id', '=', 'mahasiswa_history_pendidikans.programstudy_id')
                     ->on('kelas_perkuliahans.semester_id', '=', 'aktivitas_kuliah_mahasiswas.semester_id')
                     ->on('kelas_perkuliahans.matakuliah_id', '=', 'mk_diakui.id');
            })
            ->leftjoin('nilai_perkuliahans', function ($join) {
                $join->on('nilai_perkuliahans.mahasiswa_id', '=', 'mahasiswas.id')
                     ->on('nilai_perkuliahans.kelas_id', '=', 'kelas_perkuliahans.id');
            })
            ->where('aktivitas_kuliah_mahasiswas.semester_id', $semester_id)
            ->where('mahasiswa_history_pendidikans.programstudy_id', $programstudy_id)
            ->orderBy('mahasiswas.nim', 'asc')->get();

        if (count($selMH) > 0) {
            $filename = "Daftar_Nilai_Transfer_Per_Periode_" . $selMH[0]->tahun_ajaran . "-" . $selMH[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.nilaitransfer', compact('selMH', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.nilaitransfer', compact('selMH')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.nilaitransfer', compact('selMH')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.nilaitransfer")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function penugasandosen()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar Penugasan Dosen Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "penugasandosen";
        $title = "penugasan dosen";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function penugasandosenstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selDSN = Dosen::select('dosens.nidn', 'dosens.nama_dosen', 'dosens.jenis_kelamin', 'dosens.agama', 'dosens.tempat_lahir', 'dosens.tanggal_lahir', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang' )
            ->leftjoin('dosen_penugasans', 'dosen_penugasans.dosen_id', 'dosens.id')
            ->leftjoin('program_studies', 'program_studies.nama_program_study', 'dosen_penugasans.jurusan_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.tahunajaran_id', 'dosen_penugasans.tahunajaran_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->where('jenis_semesters.id', $semester_id)
            ->where('program_studies.id', $programstudy_id)
            ->orderBy('dosens.nidn', 'asc')->get();

        if (count($selDSN) > 0) {
            $filename = "Daftar_Penugasan_Dosen_Per_Periode_" . $selDSN[0]->tahun_ajaran . "-" . $selDSN[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.penugasandosen', compact('selDSN', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.penugasandosen', compact('selDSN')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.penugasandosen', compact('selDSN')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.penugasandosen")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function matakuliah()
    {

        $programstudy = ProgramStudy::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar Matakuliah Per Program Studi",
                "value" => ""
            ],
            1 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
            ],
            2 => [
                "name" => "format",
                "type" => "selectformat",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Format",
                "value" => ""
            ],
        ];

        $name_page = "matakuliah";
        $title = "matakuliah";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function matakuliahstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',

        ]);

        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selMK = MataKuliah::select('mata_kuliahs.kode_matakuliah', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'jenis_mata_kuliahs.jenis_matrakuliah')
            ->leftjoin('program_studies', 'program_studies.id', 'mata_kuliahs.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('jenis_mata_kuliahs', 'jenis_mata_kuliahs.id', 'mata_kuliahs.jenis_mata_kuliah')
            ->where('mata_kuliahs.programstudy_id', $programstudy_id)
            ->orderBy('mata_kuliahs.kode_matakuliah', 'asc')->get();

        if (count($selMK) > 0) {
            $filename = "Daftar_Penugasan_Dosen_Per_Periode_" . $selMK[0]->tahun_ajaran . "-" . $selMK[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.matakuliah', compact('selMK', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.matakuliah', compact('selMK')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.matakuliah', compact('selMK')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.matakuliah")->with(["error" => "Data tidak ditemukan!"]);

        }
    }

    public function kelasperkuliahan()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar Perkuliahan Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "kelasperkuliahan";
        $title = "kelas perkuliahan";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function kelasperkuliahanstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selKP = KelasPerkuliahan::select('jenjang_pendidikans.nama_jenjang', 'jurusans.nama_jurusan', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'dosen_perkuliahans.bobot_sks', 'kelas_perkuliahans.nama_kelas', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', DB::raw('count(dosen_perkuliahans.dosen_id) as jumlah_dosen'), 'countkrs.jumlah_krs' )
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
            ->groupBy('jenjang_pendidikans.nama_jenjang', 'jurusans.nama_jurusan', 'mata_kuliahs.nama_matakuliah', 'dosen_perkuliahans.bobot_sks', 'kelas_perkuliahans.nama_kelas', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester')
            ->orderBy('kelas_perkuliahans.id', 'ASC')
            ->get();

        if (count($selKP) > 0) {
            $filename = "Daftar_Kelas_Perkuliahan_Per_Periode_" . $selKP[0]->tahun_ajaran . "-" . $selKP[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.kelasperkuliahan', compact('selKP', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.kelasperkuliahan', compact('selKP')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.kelasperkuliahan', compact('selKP')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.kelasperkuliahan")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function krs()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar KRS Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "krs";
        $title = "KRS";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function krsstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selKRS = Krs::select('mahasiswas.nim', 'mahasiswas.nama', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mata_kuliahs.kode_matakuliah', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'nilai_perkuliahans.nilai_angka', 'nilai_perkuliahans.nilai_huruf', 'skala_nilais.nilai_index')
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
            ->where('kelas_perkuliahans.programstudy_id', $programstudy_id)
            ->orderBy('krs.id', 'ASC')
            ->get();

        if (count($selKRS) > 0) {
            $filename = "Daftar_KRS_Per_Periode_" . $selKRS[0]->tahun_ajaran . "-" . $selKRS[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.krs', compact('selKRS', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.krs', compact('selKRS')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.krs', compact('selKRS')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.krs")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function aktivitaskuliah()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Aktivitas Perkuliahan Mahasiswa Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "aktivitaskuliah";
        $title = "aktivitas kuliah";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function aktivitaskuliahstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selAKM = AktivitasKuliahMahasiswa::select('mahasiswas.nim', 'mahasiswas.nama', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'status_mahasiswas.status_mahasiswa', 'aktivitas_kuliah_mahasiswas.ips', 'aktivitas_kuliah_mahasiswas.ipk', 'aktivitas_kuliah_mahasiswas.jumlah_sks_semester', 'aktivitas_kuliah_mahasiswas.sks_total', 'aktivitas_kuliah_mahasiswas.biaya_kuliah' )
            ->leftjoin('mahasiswas', 'mahasiswas.id', 'aktivitas_kuliah_mahasiswas.mahasiswa_id')
            ->leftjoin('mahasiswa_history_pendidikans', 'mahasiswa_history_pendidikans.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('status_mahasiswas', 'status_mahasiswas.id', 'aktivitas_kuliah_mahasiswas.status_id')
            ->leftjoin('program_studies', 'program_studies.id', 'mahasiswa_history_pendidikans.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'aktivitas_kuliah_mahasiswas.semester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->where('aktivitas_kuliah_mahasiswas.semester_id', $semester_id)
            ->where('mahasiswa_history_pendidikans.programstudy_id', $programstudy_id)
            ->orderBy('aktivitas_kuliah_mahasiswas.id', 'ASC')
            ->get();

        if (count($selAKM) > 0) {
            $filename = "Aktivitas_Perkuliahan_Mahasiswa_Per_Periode_" . $selAKM[0]->tahun_ajaran . "-" . $selAKM[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.aktivitaskuliah', compact('selAKM', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.aktivitaskuliah', compact('selAKM')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.aktivitaskuliah', compact('selAKM')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.aktivitaskuliah")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function mahasiswalulusdo()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar Mahasiswa Lulus/ DO Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "mahasiswalulusdo";
        $title = "mahasiswa siswa lulus / do";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function mahasiswalulusdostore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selMHLD = Mahasiswa::select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.jenis_kelamin', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mahasiswa_lulus_dos.jeniskeluar_id', 'mahasiswa_lulus_dos.tanggal_keluat', 'mahasiswa_lulus_dos.no_ijazah', 'mahasiswa_lulus_dos.keterangan' )
            ->join('mahasiswa_lulus_dos', 'mahasiswa_lulus_dos.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'mahasiswa_lulus_dos.jenissemester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin('mahasiswa_history_pendidikans', 'mahasiswa_history_pendidikans.mahasiswa_id', 'mahasiswas.id')
            ->leftjoin('program_studies', 'program_studies.id', 'mahasiswa_history_pendidikans.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')

            ->where('mahasiswa_lulus_dos.jenissemester_id', $semester_id)
            ->where('mahasiswa_history_pendidikans.programstudy_id', $programstudy_id)
            ->orderBy('mahasiswas.nim', 'asc')->get();

        if (count($selMHLD) > 0) {
            $filename = "Daftar_Mahasiswa_Lulus_DO_Per_Periode_" . $selMHLD[0]->tahun_ajaran . "-" . $selMHLD[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.mahasiswalulusdo', compact('selMHLD', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.mahasiswalulusdo', compact('selMHLD')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.mahasiswalulusdo', compact('selMHLD')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.mahasiswalulusdo")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function aktivitasmengajardosen()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Aktivitas Mengajar Dosen Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "aktivitasmengajardosen";
        $title = "aktivitas mengajar dosen per periode";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function aktivitasmengajardosenstore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selAMD = DosenPerkuliahan::select('dosens.nidn', 'dosens.nama_dosen',  'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mata_kuliahs.kode_matakuliah', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'kelas_perkuliahans.nama_kelas',  'dosen_perkuliahans.bobot_sks', 'dosen_perkuliahans.jumlah_rencana_pertemuan', 'dosen_perkuliahans.jumlah_realisasi_pertemuan' )
            ->leftjoin('dosens', 'dosens.id', 'dosen_perkuliahans.dosen_id')
            ->leftjoin('kelas_perkuliahans', 'kelas_perkuliahans.id', 'dosen_perkuliahans.kelasperkuliahan_id')
            ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'kelas_perkuliahans.semester_id')
            ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
            ->leftjoin('program_studies', 'program_studies.id', 'kelas_perkuliahans.programstudy_id')
            ->leftjoin('jurusans', 'jurusans.id', 'program_studies.nama_program_study')
            ->leftjoin('jenjang_pendidikans', 'jenjang_pendidikans.id', 'program_studies.jenjang_id')
            ->leftjoin('mata_kuliahs', 'mata_kuliahs.id', 'kelas_perkuliahans.matakuliah_id')
            ->where('kelas_perkuliahans.semester_id', $semester_id)
            ->where('kelas_perkuliahans.programstudy_id', $programstudy_id)
            ->orderBy('dosens.nidn', 'asc')->get();

        if (count($selAMD) > 0) {
            $filename = "Aktivitas_Mengajar_Dosen_Per_Periode_" . $selAMD[0]->tahun_ajaran . "-" . $selAMD[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.aktivitasmengajardosen', compact('selAMD', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.aktivitasmengajardosen', compact('selAMD')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.aktivitasmengajardosen', compact('selAMD')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.aktivitasmengajardosen")->with(["error" => "Data tidak ditemukan!"]);
        }
    }

    public function transkripnilai()
    {

        $programstudy = ProgramStudy::all();
        $jenis = JenisSemester::all();
        $form = [
            0 => [
                "name" => "",
                "type" => "title",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Daftar Transkrip Mahasiswa Per Periode",
                "value" => ""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Semester",
                "value" => "jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" => "Program Study",
                "value" => "programstudy"
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

        $name_page = "transkripnilai";
        $title = "transkrip nilai";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy' => $programstudy,
            'jenis' => $jenis,
        );

        return view('akademik::exportdata.index')->with($data);
    }

    public function transkripnilaistore(Request $request)
    {


        $this->validate($request, [
            "programstudy_id" => 'required',
            "semester_id" => 'required'

        ]);

        $semester_id = $request->semester_id;
        $programstudy_id = $request->programstudy_id;
        $format = $request->format;

        $selTN = Krs::select('mahasiswas.nim', 'mahasiswas.nama', 'jurusans.nama_jurusan', 'jenjang_pendidikans.nama_jenjang', 'tahun_ajarans.tahun_ajaran', 'jenis_semesters.jenis_semester', 'mata_kuliahs.kode_matakuliah', 'mata_kuliahs.nama_matakuliah', 'mata_kuliahs.bobot_mata_kuliah', 'nilai_perkuliahans.nilai_angka', 'nilai_perkuliahans.nilai_huruf', 'skala_nilais.nilai_index')
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
                     ->orOn('nilai_perkuliahans.mahasiswa_id', '=', 'krs.mahasiswa_id');
            })
            ->leftjoin('skala_nilais', function ($join) {
                $join->on('skala_nilais.programstudy_id', '=', 'kelas_perkuliahans.programstudy_id')
                     ->orOn('skala_nilais.nilai_huruf', '=', 'nilai_perkuliahans.nilai_huruf');
            })
            ->where('krs.jenissemester_id', $semester_id)
            ->where('kelas_perkuliahans.programstudy_id', $programstudy_id)
            ->orderBy('krs.id', 'ASC')
            ->get();

        if (count($selTN) > 0) {
            $filename = "Daftar_Transkrip_Nilai_Mahasiswa_Per_Periode_" . $selTN[0]->tahun_ajaran . "-" . $selTN[0]->jenis_semester;
            if ($format == 'html') {


                return view('akademik::exportdata.transkripnilai', compact('selTN', 'format'));
            } else if ($format == 'docx') {

                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".doc"
                );

                return \Response::make(view('akademik::exportdata.transkripnilai', compact('selTN')), 200, $headers);
            } else if ($format == 'xlsx') {
                $headers = array(
                    "Content-type" => "text/html",
                    "Content-Disposition" => "attachment;Filename=" . $filename . ".xls"
                );

                return \Response::make(view('akademik::exportdata.transkripnilai', compact('selTN')), 200, $headers);
            }
        } else {
            //redirect dengan pesan error
            return redirect()->route("exportdata.transkripnilai")->with(["error" => "Data tidak ditemukan!"]);
        }
    }
}


