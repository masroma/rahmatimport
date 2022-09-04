<?php

namespace App\Imports;

use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Imports\Helper;
use App\Models\ProgramStudy;
use App\Models\JenisMataKuliah;
use DB;

class ImportMataKuliah implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(($row['kode_matakuliah']??'')!='' && ($row['nama_matakuliah']??'')!=''){
            if(!MataKuliah::where('kode_matakuliah',$row['kode_matakuliah'])->exists()){
                $progamStudy = ProgramStudy::select('program_studies.id')->join('jurusans','jurusans.id','program_studies.nama_program_study')
                ->where('jurusans.nama_jurusan','like',$row['programstudy_id'].'%')->pluck('id')->first();
                $jenis_matakuliah = JenisMataKuliah::where('jenis_matrakuliah','like',$row['jenis_mata_kuliah'].'%')->pluck('id')->first();

                return new MataKuliah([
                    'kode_matakuliah'=>$row['kode_matakuliah'],
                    'nama_matakuliah'=>$row['nama_matakuliah'],
                    'programstudy_id'=>$progamStudy,
                    'jenis_mata_kuliah'=>$jenis_matakuliah,
                    'bobot_mata_kuliah'=>$row['bobot_mata_kuliah'],
                    'bobot_tatap_muka'=>$row['bobot_tatap_muka'],
                    'bobot_pratikum'=>$row['bobot_pratikum'],
                    'bobot_praktek_lapanagn'=>$row['bobot_praktek_lapanagn'],
                    'bobot_simulasi'=>$row['bobot_simulasi'],
                    'min_nilai_kelulusan'=>$row['bobot_simulasi'],
                    'metode_pembelajaran'=>$row['bobot_simulasi'],
                    'tanggal_mulai_efektif'=>Helper::transformDate($row['tanggal_mulai_efektif']),
                    'tanggal_akhir_efektif'=>Helper::transformDate($row['tanggal_akhir_efektif'])
                ]);
            }
        }
        
    }
}
