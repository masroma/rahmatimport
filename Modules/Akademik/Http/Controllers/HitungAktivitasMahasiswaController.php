<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasKuliahMahasiswa;
use App\Models\JenisSemester;
use App\Models\StatusMahasiswa;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Queue;

class HitungAktivitasMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    public function data()
    {
        Queue::push(new \App\Jobs\CalculateIpsIpk());
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            // $semester = JenisSemester::orderBy('id','DESC')->pluck('id')->first();
            $semester = 6;
            
            $data = Mahasiswa::with(['totalKrs','Krs' => function($a) use($semester){
                $a->where('jenissemester_id',$semester);
            },'aktivitasKuliahMahaswa' => function($b) use($semester){
                $b->with('Status')->where('semester_id',$semester);
            },'nilai_perkuliahan'=>function($c) use ($semester){
                $c->with(['kelas'=>function($d) use ($semester){
                    $d->where('semester_id',$semester);
                },'master_nilai']);
            },'calculate_nilai'=>function($b) use($semester){
                $b->where('semester_id',$semester);
            }])
            ->whereHas('Krs',function($a) use($semester){
                $a->where('jenissemester_id',$semester);
            })
           ->SELECT('*')
            ->get();
            // dd($data);
            // $data = Mahasiswa::with(['totalKrs'])
            // ->get();
            return DataTables::of($data)
                    ->addColumn('total_sks', function($data){
                        $totalBobot = 0;
                       foreach($data->totalkrs as $row){
                          $totalBobot += $row->matakuliah->bobot_mata_kuliah;
                       }
                       return number_format($totalBobot, 2, '.', '');
                    })
                    ->addColumn('input_status',function($data){
                        $html = '<select data-id="'.$data->id.'" name="status_id[]" class="select2 browser-default"> ';
                        foreach(StatusMahasiswa::get() as $value){
                            $html .= '<option value="'.$value->id.'">'.$value->status_mahasiswa.'</option> ';
                        }
                        $html .= '</select>';
                        return $html;
                    })
                    ->addColumn('input_jumlah_sks',function($data) use ($semester){
                        $sks_semester = 0;
                        
                        foreach($data->calculate_nilai as $item){
                           $sks_semester = $item->sks_semester;
                        }
                        $html = '<input placeholder="Jumlah SKS" name="jumlah_sks_semester[]" id="jumlah_sks_semester_'.$data->id.'" data-id="'.$data->id.'" type="text" class="validate" value="'.$sks_semester.'">';
                        $html .= '<input name="mahasiswa_id[]" id="mahasiswa_id'.$data->id.'" data-id="'.$data->id.'" type="hidden" class="validate" value="'.$data->id.'">';
                        $html .= '<input name="semester_id[]" id="semester_id'.$semester.'" data-id="'.$semester.'" type="hidden" class="validate" value="'.$semester.'">';
                        return $html;
                    })
                    
                    ->addColumn('input_jumlah_sks_total',function($data){
                        $total_sks = 0;
                        
                        foreach($data->calculate_nilai as $item){
                           $total_sks = $item->total_sks;
                        }
                        $html = '<input placeholder="Jumlah SKS Total" name="sks_total[]" id="sks_total_'.$data->id.'" data-id="'.$data->id.'" type="text" class="validate" value="'.$total_sks.'">';
                        return $html;
                    })
                    ->addColumn('input_ipk',function($data){
                        $ipk = 0;
                        
                        foreach($data->calculate_nilai as $item){
                           $ipk = $item->ipk;
                        }
                        $html = '<input placeholder="IPK" name="ipk[]" id="ipk_'.$data->id.'" data-id="'.$data->id.'" type="text" class="validate" value="'.$ipk.'">';
                        return $html;
                    })
                    ->addColumn('input_ips',function($data) {
                        $ips = 0;
                        
                        foreach($data->calculate_nilai as $item){
                           $ips = $item->ips;
                        }
                        $html = '<input placeholder="IPS" name="ips[]" id="ips_'.$data->id.'" data-id="'.$data->id.'" type="text" class="validate" value="'.$ips.'">';
                        return $html;
                    })
                    ->addColumn('input_biaya_semester',function($data){
                        $html = '<input placeholder="Biaya Semester" name="biaya_kuliah[]" id="biaya_kuliah_'.$data->id.'" data-id="'.$data->id.'" type="text" class="validate" value="">';
                        return $html;
                    })
                    ->addColumn('total_sks_semester', function($data){
                        $totalBobotSemester = 0;
                        foreach($data->Krs as $row){
                            $totalBobotSemester += $row->matakuliah->bobot_mata_kuliah;
                        }
                        return number_format($totalBobotSemester, 2, '.', '');
                    })
                    ->addColumn('akm', function($data){
                        
                        return json_decode($data->aktivitasKuliahMahaswa,true)[0]??[
                            "status"=>[
                                "status_mahasiswa"=>""
                            ],
                            "jumlah_sks_semester"=>"",
                            "sks_total"=>"",
                            "ipk"=>"",
                            "ips"=>"",
                            "biaya_kuliah"=>"",
                        ];
                    })
                    ->addColumn('krs_nilai', function($data){
                        return json_decode($data->krs_nilai,true)[0]??[
                            "status_id"=>"",
                            "jumlah_sks_semester"=>"",
                            "sks_total"=>"",
                            "ipk"=>"",
                            "ips"=>"",
                            "biaya_kuliah"=>"",
                        ];
                    })
                    ->addColumn('action', function ($data) use($semester) {

                        $btn = '';

                        $btn .= $data->nama.' <a class="waves-effect green waves-light btn modal-trigger mr-2"onClick="detailKrs(this)" data-id="'.$data->id.'" data-semester="'.$semester.'" href="#detailKrs">Detail KRS</a>';

                    

                        // if ($canUpdate) {
                        //     $btn .= '<a class="btn-floating btn-small mr-2" href="aktivitaskuliahmahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        // }

                        // if ($canDelete) {
                        //     $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        // }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitaskuliahmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;

                        
                    })
                    ->addIndexColumn()
                    ->rawColumns(['input_status','input_jumlah_sks','input_jumlah_sks_total','input_ipk','input_ips','input_biaya_semester','action'])
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

    public function dataKrs($id){
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            $semester = JenisSemester::orderBy('id','DESC')->pluck('id')->first();
            
            $data = Krs::with('Matakuliah')->where('jenissemester_id', $semester)->where('mahasiswa_id', $id)->get();
         
            return DataTables::of($data)

                 
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
        $canCreate = Gate::allows('aktivitaskuliahmahasiswa-create');
        $name_page = "hitungaktivitaskmahasiswa";
        $title = "Hitung aktivitas kuliah mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::hitungakm.index')->with($data);
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
        // dd(request()->all());
        $save = false;
        DB::beginTransaction();
        $params = request()->all();
        unset($params['_token']);
        unset($params['page-length-option_length']);
        for($i=0;$i<count(request('mahasiswa_id'));$i++){
            try {
                // $validate = Validator::make($value,[
                //     'mahasiswa_id' => 'required',
                //     'semester_id' => 'required',
                //     'status_id' => 'required',
                //     'ips' => 'required',
                //     'ipk' => 'required',
                //     'jumlah_sks_semester' => 'required',
                //     'sks_total' => 'required',
                //     'biaya_kuliah' => 'required'
                // ]);
        
                if(AktivitasKuliahMahasiswa::where(['mahasiswa_id'=>$params['mahasiswa_id'][$i],'semester_id'=>$params['semester_id'][$i]])->exists()){
                    $data =[
                       'status_id'=> $params['status_id'][$i],
                        'ips'=>$params['ips'][$i],
                        'ipk'=>$params['ipk'][$i],
                        'jumlah_sks_semester'=>$params['jumlah_sks_semester'][$i],
                        'sks_total'=>$params['sks_total'][$i],
                        'biaya_kuliah'=>$params['biaya_kuliah'][$i]
                    ];
                    $save = AktivitasKuliahMahasiswa::where(['mahasiswa_id'=>$params['mahasiswa_id'][$i],'semester_id'=>$params['semester_id'][$i]])->update($data);
                }else{
                    $save = new AktivitasKuliahMahasiswa();
                    $save->mahasiswa_id =$params['mahasiswa_id'][$i];
                    $save->semester_id =$params['semester_id'][$i];
                    $save->status_id =$params['status_id'][$i];
                    $save->ips =$params['ips'][$i];
                    $save->ipk =$params['ipk'][$i];
                    $save->jumlah_sks_semester =$params['jumlah_sks_semester'][$i];
                    $save->sks_total =$params['sks_total'][$i];
                    $save->biaya_kuliah =$params['biaya_kuliah'][$i];
                    $save->save();
    
                }
                DB::commit();
                
            } catch (ModelNotFoundException $exception) {
                DB::rollback();
                // return back()->with('error', $exception->getMessage());
            }
        }
        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('hitungaktivitaskuliahmahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('hitungaktivitaskuliahmahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function detailKhs()
    {
        $semester_id = request('semester_id')??'';
        $mahasiswa_id = request('mahasiswa_id')??'';
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
            return response()->json($selKRSMahasiswa);
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
        return view('akademik::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
