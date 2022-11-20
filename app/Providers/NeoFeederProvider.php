<?php

namespace App\Providers;

use Exception;
use GuzzleHttp\Client;
use Throwable;
use Illuminate\Support\Facades\Http;


class NeoFeederProvider {

    protected $username = '031041';
    protected $password = 'Paramadina1998';
    protected $base_url = 'http://akademik.paramadina.ac.id:8100/ws/live2.php';

    public function getAgamaId($nama_agama) {
        $agama_list = [
            [
                "id_agama" => 2,
                "nama_agama" => "kristen"
            ],
            [
                "id_agama" =>  5,
                "nama_agama" =>"budha"
            ],
            [
                "id_agama" => 4,
                "nama_agama" => "hindu"
            ],
            [
                "id_agama" => 1,
                "nama_agama" => "islam"
            ],
            [
                "id_agama" => 99,
                "nama_agama" => "lainnya"
            ],
            [
                "id_agama" => 3,
                "nama_agama" =>  "katolik"
            ],
            [
                "id_agama" => 6,
                "nama_agama" => "konghucu"
            ]
        ];

        $data = collect($agama_list)->where('nama_agama', $nama_agama)->first();
        return $data->id_agama;

    }

    private function getToken() {
        try{

            $request = Http::post($this->base_url, [
                'act' => 'GetToken',
                'username' => $this->username,
                'password' => $this->password
            ]);

            if($request->object()->error_code !== 0) {
                throw new Exception("Invalid Credentials");
            }

            return $request->object()->data->token;

        }catch(Throwable $th) {
            throw $th;
        }
    }

    public function sendRequestToNewFeeder($action, $data) {

        try {

            $body = [
                'act' => $action,
                'token' => $this->getToken(),
                ...$data
            ];
            $request = Http::post($this->base_url, $body);
            if(!$request->successful()) {
                throw new Exception("Somethink Error");
            }
            $res = $request->collect()->all();

            if($res['error_code'] !== 0){
                throw new Exception($res['error_desc']);
            }

            return $res["data"];

        }catch(Throwable $th){
            throw $th;
        }

    }

}
