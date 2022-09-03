<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerguruanTinggi;

class PerguruanTinggiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "nama"=>"Universitas Raharja",
                "kode"=>"0001",
                "alamat"=>"Cikokol",
                "province_id"=>36,
                "city_id"=>3603,
                "district_id"=>3603120,
                "village_id"=>3603120010,
                "kode_pos"=>15560,
            ],
            [
                "nama"=>"Universitas Muhammadiyah Tangerang",
                "kode"=>"0002",
                "alamat"=>"Cikokol",
                "province_id"=>36,
                "city_id"=>3603,
                "district_id"=>3603120,
                "village_id"=>3603120010,
                "kode_pos"=>15560,
            ],
            [
                "nama"=>"Universitas Syeikh Yusuf",
                "kode"=>"0003",
                "alamat"=>"Cikokol",
                "province_id"=>36,
                "city_id"=>3603,
                "district_id"=>3603120,
                "village_id"=>3603120010,
                "kode_pos"=>15560,
            ],
        ];
        foreach($data as $value){
            PerguruanTinggi::insert($value);
        }
    }
}
