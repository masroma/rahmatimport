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
            $res = $request->object();

            return $res;

        }catch(Throwable $th){
            throw $th;
        }

    }

}
