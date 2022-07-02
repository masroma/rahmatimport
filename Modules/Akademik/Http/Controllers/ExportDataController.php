<?php

namespace Modules\Akademik\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use App\Models\JenisSemester;
use App\Models\ProgramStudy;
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
         $this->middleware("permission:exportdata-view|exportdata-create|exportdata-edit|exportdata-show|exportdata-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:exportdata-view", ["only" => ["index"]]);
         $this->middleware("permission:exportdata-create", ["only" => ["create","store"]]);
         $this->middleware("permission:exportdata-edit", ["only" => ["edit","update"]]);
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
                "placeholder" =>"Daftar Mahasiswa Per Semester",
                "value" =>""
            ],
            1 => [
                "name" => "semester_id",
                "type" => "selectsemester",
                "relasi" => $jenis,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" =>"Semester",
                "value" =>"jenis_semester"
            ],
            2 => [
                "name" => "programstudy_id",
                "type" => "selectprogram",
                "relasi" => $programstudy,
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" =>"Program Study",
                "value" =>"programstudy"
            ],
            3 => [
                "name" => "sortbymahasiswa",
                "type" => "selectsortbymahasiswa",
                "relasi" => "",
                "col" => "",
                "data" => "",
                "placeholder" =>"Urutkan Berdasarkan",
                "value" =>""
            ],
            4 => [
                "name" => "format",
                "type" => "selectformat",
                "relasi" => "",
                "col" => "s8 offset-s2 m8 offset-m2",
                "data" => "",
                "placeholder" =>"Format",
                "value" =>""
            ],
        ];

        $name_page = "mahasiswa";
        $title = "export data mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'programstudy'=>$programstudy,
            'jenis'=>$jenis,
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



        DB::beginTransaction();
        try {

            $this->validate($request, [
                "programstudy_id" => 'required',
                "semester_id" => 'required'

            ]);

            $semester_id = $request->semester_id;
            $programstudy_id = $request->programstudy_id;



            $sortbymahasiswa =  '';
            if ( $request->sortbymahasiswa == 'jenis_pendaftaran' || $request->sortbymahasiswa == 'programstudy_id' ){
                $sortbymahasiswa =  'mahasiswa_history_pendidikans.'.$request->sortbymahasiswa;
            }else if( $request->sortbymahasiswa == 'status'  ){
                $sortbymahasiswa =  'aktivitas.'.$request->sortbymahasiswa.'_id';
            }else{
                $sortbymahasiswa =  'mahasiswas.'.$request->sortbymahasiswa;
            }
            $sorttype = $request->sorttype;
            $format = $request->format;

            $selMH = Mahasiswa::leftjoin('aktivitas_kuliah_mahasiswas', 'aktivitas_kuliah_mahasiswas.mahasiswa_id', 'mahasiswas.id')
                    ->leftjoin('jenis_semesters', 'jenis_semesters.id', 'aktivitas_kuliah_mahasiswas.semester_id')
                    ->leftjoin('tahun_ajarans', 'tahun_ajarans.id', 'jenis_semesters.tahunajaran_id')
                    ->leftjoin('status_mahasiswas', 'status_mahasiswas.id', 'aktivitas_kuliah_mahasiswas.semester_id')
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


            $filename = "Daftar_Mahasiswa_Per_Semester_".$selMH[0]->tahun_ajaran."-".$selMH[0]->jenis_semester;
            if ( $format == 'html' ) {


                return view('akademik::exportdata.mahasiswa', compact('selMH', 'format'));

            }else if( $format == 'docx' ){

                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$filename.".doc"
                );

                return \Response::make(view('akademik::exportdata.mahasiswa', compact('selMH')),200, $headers);
            }else if( $format == 'xlsx' ){
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$filename.".xls"
                );

                return \Response::make(view('akademik::exportdata.mahasiswa', compact('selMH')),200, $headers);
            }


            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with("success", $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route("matakuliah.index")->with(["success" => "Data Berhasil Disimpan!"]);
        } else {
            //redirect dengan pesan error
            return redirect()->route("matakuliah.index")->with(["error" => "Data Gagal Disimpan!"]);
        }
    }
}
