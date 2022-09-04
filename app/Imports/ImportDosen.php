<?php

namespace App\Imports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Imports\Helper;

class ImportDosen implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    

    public function model(array $row)
    {
        if(($row['nidn']??'')!='' && ($row['nama']??'')!=''){
            if(!Dosen::where('nidn',$row['nidn'])->exists()){
                return new Dosen([
                    'nama_dosen'=>$row['nama'],
                    'tempat_lahir'=>$row['tempat_lahir'],
                    'jenis_kelamin'=>$row['jenis_kelamin'],
                    'nidn'=>$row['nidn'],
                    'tanggal_lahir'=>Helper::transformDate($row['tanggal_lahir']),
                    'agama'=>$row['agama'],
                ]);
            }
        }
    }
}
