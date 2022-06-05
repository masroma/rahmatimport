<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
class GlobalController extends Controller
{
    public function getCity($id)
    {
        $data = City::where('province_id', $id)->get();
        return $data;
    }

    public function getDistrict($id)
    {
        $data = District::where('regency_id', $id)->get();
        return $data;
    }

    public function getVillage($id)
    {
        $data = Village::where('district_id', $id)->get();
        return $data;
    }
}
