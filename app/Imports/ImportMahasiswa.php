<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportMahasiswa implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(($row['nim']??'')!='' && ($row['nama']??'')!=''){
            if(!Mahasiswa::where('nim',$row['nim'])->exists()){
                return new Mahasiswa([
                    'nim'=>$row['nim'],
                    'nama'=>$row['nama'],
                    'tempat_lahir'=>$row['tempat_lahir'],
                    'jenis_kelamin'=>$row['jenis_kelamin'],
                    'ibu_kandung'=>$row['ibu_kandung'],
                    'tanggal_lahir'=>$row['tanggal_lahir'],
                    'agama'=>$row['agama'],
                ]);
            }

        }

    }
}
