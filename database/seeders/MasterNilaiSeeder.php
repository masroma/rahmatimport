<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterNilai;

class MasterNilaiSeeder extends Seeder
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
                "nilai_huruf"=>"A",
                "nilai_bawah"=>80.00,
                "nilai_atas"=>100.00,
                "ip"=>4.00
            ],
            [
                "nilai_huruf"=>"A-",
                "nilai_bawah"=>77.50,
                "nilai_atas"=>79.99,
                "ip"=>4.75
            ],
            [
                "nilai_huruf"=>"A/B",
                "nilai_bawah"=>75.00,
                "nilai_atas"=>77.49,
                "ip"=>3.50
            ],
            [
                "nilai_huruf"=>"B+",
                "nilai_bawah"=>72.50,
                "nilai_atas"=>74.99,
                "ip"=>3.25
            ],
            [
                "nilai_huruf"=>"B",
                "nilai_bawah"=>70.00,
                "nilai_atas"=>72.49,
                "ip"=>3.00
            ],
            [
                "nilai_huruf"=>"B-",
                "nilai_bawah"=>67.50,
                "nilai_atas"=>69.99,
                "ip"=>2.75
            ],
            [
                "nilai_huruf"=>"B/C",
                "nilai_bawah"=>65.00,
                "nilai_atas"=>67.49,
                "ip"=>4.00
            ],
            [
                "nilai_huruf"=>"C+",
                "nilai_bawah"=>62.50,
                "nilai_atas"=>64.99,
                "ip"=>2.25
            ],
            [
                "nilai_huruf"=>"C",
                "nilai_bawah"=>60.00,
                "nilai_atas"=>62.49,
                "ip"=>2.00
            ],
            [
                "nilai_huruf"=>"C-",
                "nilai_bawah"=>57.00,
                "nilai_atas"=>59.99,
                "ip"=>1.75
            ],
            [
                "nilai_huruf"=>"D",
                "nilai_bawah"=>55.00,
                "nilai_atas"=>56.99,
                "ip"=>1.00
            ],
            [
                "nilai_huruf"=>"E",
                "nilai_bawah"=>00.00,
                "nilai_atas"=>54.99,
                "ip"=>0.00
            ],
        ];
        foreach($data as $value){
            MasterNilai::insert($value);
        }
    }
}
