<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Models\CalculateIpsIpk as Calculate;

class CalculateIpsIpk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $programstudy_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($programstudy_id=null)
    {
        $this->programstudy_id = $programstudy_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ipk =[];
        $total_sks = [];
        if($this->programstudy_id == null){
            Calculate::truncate();
        } else {
            Calculate::where('programstudy_id',$this->programstudy_id)->delete();
        }
        $data = DB::select("SELECT a.id mahasiswa_id,f.programstudy_id, a.nama,round(sum(f.nilai_index)/COUNT(a.nama),2) ips,
        d.jenissemester_id,d.sks sks_semester, d.jenissemester_id semester_id
        FROM mahasiswas a
        JOIN nilai_perkuliahans b ON a.id = b.mahasiswa_id
        JOIN kelas_perkuliahans g ON g.id = b.kelas_id
        JOIN (
		  	 	SELECT SUM(b.bobot_mata_kuliah)sks,a.jenissemester_id,a.mahasiswa_id
	        FROM krs a
	        JOIN mata_kuliahs b ON a.matakuliah_id = b.id
	        GROUP BY a.jenissemester_id, a.mahasiswa_id
		  ) d ON d.mahasiswa_id = a.id 
        JOIN skala_nilais f ON f.nilai_huruf = b.nilai_huruf AND f.programstudy_id = g.programstudy_id
        ".($this->programstudy_id != null? "where f.programstudy_id = ".$this->programstudy_id:"")."
        GROUP BY  a.id, a.nama,d.jenissemester_id
        ORDER BY a.id, d.jenissemester_id;
        ");
        $this->calculate = new Calculate();
        $mahasiswa_id = 0;
        // $tmp_ipk =[];
        // $tmp_total_sks = [];
        foreach($data as $value){
            if($mahasiswa_id!=$value->mahasiswa_id){
                $tmp_ipk =[];
                $tmp_total_sks = [];
            }

            $params = array_filter((Array)$value,function($key){
                return in_array($key,$this->calculate->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            array_push($tmp_ipk,$params['ips']);
            array_push($tmp_total_sks,$params['sks_semester']);
            $ipk[$params['mahasiswa_id']] = $tmp_ipk;
            $total_sks[$params['mahasiswa_id']] = $tmp_total_sks;
            $params['ipk'] = array_sum($ipk[$params['mahasiswa_id']])/count($ipk[$params['mahasiswa_id']]);
            $params['total_sks'] =  array_sum($total_sks[$params['mahasiswa_id']]);
            $already = Calculate::where([
                'mahasiswa_id'=>$params['mahasiswa_id'],
                'semester_id'=>$params['semester_id']
            ]);
            if($already->exists()){
                $already->update($params);
            }else{
                Calculate::create($params);
            }
            $mahasiswa_id = $value->mahasiswa_id;
        }
    }
}
