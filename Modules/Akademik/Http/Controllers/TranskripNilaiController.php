<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Gate;
use Queue;
use App\Models\ProgramStudy;
use DB;

class TranskripNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $canCreate = Gate::allows('mahasiswa-create');
        $name_page = "transkripnilai";
        $title = "Transkrip Nilai";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::transkripnilai.index',$data);
    }
    public function data()
    {
        $data = DB::select("
        SELECT a.id,c.nama_jurusan, d.nama_jenjang, b.total_mahasiswa, b.angkatan,ifnull(e.sudah_hitung,0) sudah_hitung
        FROM program_studies a
        JOIN (
            SELECT COUNT(*) total_mahasiswa, YEAR(b.tanggal_masuk) angkatan,b.programstudy_id
            FROM mahasiswas a
            JOIN mahasiswa_history_pendidikans b ON a.id = b.mahasiswa_id
            GROUP BY YEAR(b.tanggal_masuk), b.programstudy_id
        ) b ON a.id = b.programstudy_id
        JOIN jurusans c ON c.id = a.nama_program_study
        JOIN jenjang_pendidikans d ON d.id = a.jenjang_id
        LEFT JOIN (
            SELECT COUNT(*) sudah_hitung, programstudy_id
            FROM calculate_ips_ipk 
            GROUP BY programstudy_id
        ) e ON e.programstudy_id = a.nama_program_study
        ");
        return DataTables::of($data)
        ->addColumn('program_study',function($data){
            return $data->nama_jenjang.' '.$data->nama_jurusan;
        })
        ->addColumn('action',function($data){
            return ' <a class="waves-effect green waves-light btn mr-2" onclick="calculate(this)" data-programstudyid="'.$data->id.'" href="#">Hitung Transkrip</a>';
        })
        ->addIndexColumn()
        ->make(true);
    }
    public function hitungTranskrip($id)
    {
        return Queue::push(new \App\Jobs\CalculateIpsIpk($id));
    }
}
