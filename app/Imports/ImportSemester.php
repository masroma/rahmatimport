<?php

namespace App\Imports;

use App\Models\JenisSemester;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportSemester implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(($row['tahunajaran']??'')!='' && ($row['jenis_semester']??'')!=''){
            $tahunajaran_id = TahunAjaran::where('tahun_ajaran',$row['tahun_ajaran'])->pluck('id')->first();
            if(!JenisSemester::where(['tahunajaran_id'=>$tahunajaran_id,'jenis_semester'=>$row['jenis_semester']])->exists()){
                return new JenisSemester([
                    'tahunajaran_id'=>$tahunajaran_id,
                    'jenis_semester'=>$row['jenis_semester']
                ]);
            }
        }
    }
}
