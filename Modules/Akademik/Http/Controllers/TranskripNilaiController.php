<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Gate;
use Queue;
use App\Models\ProgramStudy;
use App\Models\Mahasiswa;
use App\Models\NilaiPerkuliahan;
use DB;

class TranskripNilaiController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:transkripnilai-view|transkripnilai-create|transkripnilai-edit|transkripnilai-show|transkripnilai-delete', ['only' => ['index','store']]);
         $this->middleware('permission:transkripnilai-view', ['only' => ['index']]);
         $this->middleware('permission:transkripnilai-create', ['only' => ['create','store']]);
         $this->middleware('permission:transkripnilai-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:transkripnilai-show', ['only' => ['show']]);
         $this->middleware('permission:transkripnilai-delete', ['only' => ['destroy']]);

         $this->middleware('permission:cektranskripmahasiswa-view|cektranskripmahasiswa-create|cektranskripmahasiswa-edit|cektranskripmahasiswa-show|cektranskripmahasiswa-delete', ['only' => ['index','store']]);
         $this->middleware('permission:cektranskripmahasiswa-view', ['only' => ['index']]);
         $this->middleware('permission:cektranskripmahasiswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:cektranskripmahasiswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cektranskripmahasiswa-show', ['only' => ['show']]);
         $this->middleware('permission:cektranskripmahasiswa-delete', ['only' => ['destroy']]);

    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $canCreate = Gate::allows('transkripnilai-create');
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
        ) e ON e.programstudy_id = a.id
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
    public function checkTranskripMahasiswa()
    {
        $canCreate = Gate::allows('transkripnilai-create');
        $name_page = "cektranskripmahasiswa";
        $title = "Cek Transkrip Mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'mahasiswa'=>Mahasiswa::all()
        );
        return view('akademik::cektranskripmahasiswa.index',$data);
    }
    public function detailTranskripMahasiswa()
    {
        $canCreate = Gate::allows('transkripnilai-create');
        $name_page = "cektranskripmahasiswa";
        $title = "Cek Transkrip Mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::cektranskripmahasiswa.detail',$data);
    }
    public function getMahasiswa($id)
    {
        $data = Mahasiswa::with(['Riwayatpendidikan'=>function($e){
            $e->with(['Programstudy'=>function($d){
                $d->with('jurusan');
            }]);
        },'aktivitasKuliahMahaswa'=>function($q){
            $q->with('Status')->orderBy('semester_id','desc')->first();
        }])->findOrFail($id);
        return response()->json($data);
    }
    public function checkTranskripMahasiswaData($id)
    {
        $data = DB::select("
        SELECT a.id,c.kode_matakuliah, c.nama_matakuliah, CONCAT(e.tahun_ajaran,' ',d.jenis_semester) semester, c.bobot_mata_kuliah,a.nilai_angka,a.nilai_huruf,f.nilai_index,c.bobot_mata_kuliah*f.nilai_index nindeks, a.semester_ke
        FROM nilai_perkuliahans a
        JOIN kelas_perkuliahans b ON a.kelas_id = b.id
        JOIN mata_kuliahs c ON c.id = b.matakuliah_id
        JOIN jenis_semesters d ON d.id = b.semester_id 
        JOIN tahun_ajarans e ON e.id = d.tahunajaran_id
        JOIN mahasiswa_history_pendidikans g ON g.mahasiswa_id = a.mahasiswa_id
        JOIN skala_nilais f ON f.nilai_huruf = a.nilai_huruf AND g.programstudy_id = f.programstudy_id
        WHERE a.mahasiswa_id = :mahasiswa_id
        order by d.tahunajaran_id asc
        ",['mahasiswa_id'=>$id]);
        return DataTables::of($data)
        ->addColumn('semester_ke',function($data){
            $input = '<input placeholder="Semester Ke" name="semester_ke[]" id="semester_ke_'.$data->id.'" data-id="'.$data->id.'" type="text" class="validate" value="'.($data->semester_ke==0?'':$data->semester_ke).'">';
            $input .= '<input placeholder="Semester Ke" name="nilai_id[]" id="nilai_id_'.$data->id.'" data-id="'.$data->id.'" type="hidden" class="validate" value="'.$data->id.'">';
            return $input;
        })
        ->addColumn('action',function($data){
            return '<input name="chk_'.$data->id.'" id="chk_'.$data->id.'" class="chk" data-id="'.$data->id.'" value="on" onclick="changeValue(this)" type="checkbox" checked>';
        })
        ->addIndexColumn()
        ->rawColumns(['semester_ke','action'])
        ->make(true);
    }
    public function storeTranskripNilai()
    {
        $ins = 0;
        for($i=0;$i<count(request('nilai_id'));$i++){
            $nilaiPerkuliahan = NilaiPerkuliahan::where('id',request('nilai_id')[$i]);
            if(request()->has('chk_'.request('nilai_id')[$i])){
                if($nilaiPerkuliahan->exists()){
                    $updsts = $nilaiPerkuliahan->update([
                        'semester_ke'=>request('semester_ke')[$i]
                    ]);
                    if($updsts){
                        $ins = $ins + 1; 
                    }
                }
            }
        }
        if($ins== 0 )return redirect()->back()->with(['error' => 'Data Berhasil Disimpan!, '.$ins.' dari '.count(request('nilai_id'))]);
        return redirect()->back()->with(['success' => 'Data Berhasil Disimpan!,'.$ins.' dari '.count(request('nilai_id'))]);
    }
}
