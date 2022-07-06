<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JenisSemester;
use App\Models\TahunAjaran;
use App\Models\Jurusan;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RekapitulasiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:rekappelaporan-view|rekappelaporan-show', ['only' => ['index','show']]);
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
                "relasi" => $semester??[],
                "col" => "s12",
                "data" => $this->rekappelaporan->semester_id??'',
                "placeholder" =>"Jenis Semester",
                "value" =>"nama"
            ],
            [
                "name" => "programstudy_id",
                "type" => "select",
                "relasi" => $jurusan??[],
                "col" => "s12",
                "data" => $this->rekappelaporan->programstudy_id??'',
                "placeholder" =>"Program Study",
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
        $canCreate = Gate::allows('rekappelaporan-create');
        $name_page = "rekappelaporan";
        $title = "Rekap Pelaporan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'form'=>$form
        );
        return view('akademik::rekapitulasi.rekappelaporan.index')->with($data);
    }

    public function show_rekappelaporan()
    {
        $data =JenisSemester::with(['tahun_ajaran'])->get();;
        // dd($data);
        $this->exportView('akademik::rekapitulasi.rekappelaporan.preview');
        return $this->export('html',$data);
    }

    public function export($format,$data)
    {
        $filename = $this->filename;;
        if ( $format == 'html' ) {


            return view($this->exportView, $data);

        }else if( $format == 'docx' ){

            $headers = array(
                "Content-type"=>"text/html",
                "Content-Disposition"=>"attachment;Filename=".$filename.".doc"
            );

            return \Response::make(view($this->exportView, $data),200, $headers);
        }else if( $format == 'xlsx' ){
            $headers = array(
                "Content-type"=>"text/html",
                "Content-Disposition"=>"attachment;Filename=".$filename.".xls"
            );

            return \Response::make(view($this->exportView, $data),200, $headers);
        }
        return;
    }
}
