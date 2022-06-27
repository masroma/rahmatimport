<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\KelasPerkuliahan;
use App\Models\PenggunaanRuangan;
use App\Models\RuangPerkuliahan;
use App\Models\RuangGedung;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;


class RuangPerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
         $this->middleware("permission:ruangperkuliahan-view|ruangperkuliahan-create|ruangperkuliahan-edit|ruangperkuliahan-show|ruangperkuliahan-delete", ["only" => ["index","store"]]);
         $this->middleware("permission:ruangperkuliahan-view", ["only" => ["index"]]);
         $this->middleware("permission:ruangperkuliahan-create", ["only" => ["create","store"]]);
         $this->middleware("permission:ruangperkuliahan-edit", ["only" => ["edit","update"]]);
         $this->middleware("permission:ruangperkuliahan-show", ["only" => ["show"]]);
         $this->middleware("permission:ruangperkuliahan-delete", ["only" => ["destroy"]]);
    }


    private function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $lauch = explode($delimiters[0], $ready);

        return $lauch;
    }

    use ValidatesRequests;

    public function data()
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("ruangperkuliahan-edit");
            $canDelete = Gate::allows("ruangperkuliahan-delete");
            $data = RuangGedung::with('Perkuliahan','listkampus','Uts','Uas')->withCount(['Perkuliahan','Uts','Uas'])->get();
            return DataTables::of($data)

            ->addColumn('kampus',function($data){
                return $data->ListKampus->cabang_kampus;
            })

                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="ruangperkuliahan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;
                    })
                    ->rawColumns(['colors','action'])
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    "status" => false,
                    "message" => $e->getMessage()
                ]
            );
        }

    }

    public function index()
    {
        $canCreate = Gate::allows('ruangperkuliahan-create');
        $name_page = "ruangperkuliahan";
        $title = "ruang perkuliahan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::ruangperkuliahan.index')->with($data);
    }


    public function create()
    {

        $datasenin = RuangPerkuliahan::with('kelasPerkuliahan')->where('ruang_id',0)->pluck('hari','waktu');

        $senin = "";
        $selasa = "";
        $rabu = "";
        $kamis = "";
        $jumat = "";
        $sabtu ="";
        foreach($datasenin as $b => $value){
            if($value == "senin"){
                $senin .= $b;
            }else if($value == "selasa"){
                $selasa .= $b;
            }else if($value == "rabu"){
                $rabu .= $b;
            }else if($value == "kamis"){
                $kamis .= $b;
            }else if($value == "jumat"){
                $jumat .= $b;
            }else if($value == "sabtu"){
                $sabtu.= $b;
            }
        }
        $senin = $this->multiexplode(array('[', ']', '"', '"', ','), $senin);
        $selasa = $this->multiexplode(array('[', ']', '"', '"', ','), $selasa);
        $rabu= $this->multiexplode(array('[', ']', '"', '"', ','), $rabu);
        $kamis = $this->multiexplode(array('[', ']', '"', '"', ','), $kamis);
        $jumat = $this->multiexplode(array('[', ']', '"', '"', ','), $jumat);
        $sabtu = $this->multiexplode(array('[', ']', '"', '"', ','), $sabtu);

        $kelasperkuliahan = KelasPerkuliahan::with('Matakuliah')->get();
        $penggunaanruang = PenggunaanRuangan::all();
        $open_time = strtotime("07:00");
        $close_time = strtotime("21:00");
        $name_page = "ruang perkuliahan";
        $title = "ruang perkuliahan";
        $data = array(
            'page' => $name_page,
            "title" => $title,
            "open_time" => $open_time,
            "close_time" => $close_time,
            "kelasperkuliahan" => $kelasperkuliahan,
            "penggunaanruang" => $penggunaanruang,
            "senin" =>$senin,
            "selasa" =>$selasa,
            "rabu" => $rabu,
            "kamis" => $kamis,
            "jumat" => $jumat,
            "sabtu" => $sabtu

        );
        return view('akademik::ruangperkuliahan.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    // public function create()
    // {
    //     return view('akademik::create');
    // }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


        DB::beginTransaction();
        try {
            $this->validate($request, [
                'kelasperkuliahan_id' => 'required',
                'penggunaanruang_id' => 'required',
            ]);

            $open_time = strtotime($request->jam_mulai);

            $close_time = strtotime($request->jam_akhir);
            $output = "";
            for ($i = $open_time; $i < $close_time; $i+= 300) {
                $output .= date('H:i',$i)." ";
            }

            $ar = explode(" ",$output);
            $waktu = json_encode($ar);


            $save = new RuangPerkuliahan();
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->penggunaanruang_id = $request->penggunaanruang_id;
            $save->ruang_id = $request->ruang_id ?? 0;
            $save->kode = $request->kode;
            $save->kelasperkuliahan_id = $request->kelasperkuliahan_id;
            $save->hari = $request->hari;
            $save->waktu = $waktu;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $canCreate = Gate::allows('ruangperkuliahan-create');
        $name_page = "ruangperkuliahan";
        $title = "kelas perkuliahan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::ruangperkuliahan.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        return view('akademik::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

    }

    public function dataKelas($id)
    {
        try {
            // $canShow = Gate::allows("kelaskuliahshow");
            $canUpdate = Gate::allows("kelasperkuliahan-edit");
            $canDelete = Gate::allows("kelasperkuliahan-delete");
            $data = RuangPerkuliahan::get();
            return DataTables::of($data)


                    ->addColumn("action", function ($data) use ($canUpdate, $canDelete) {

                        $btn = "";

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kelasperkuliahan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="matakuliah/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    "status" => false,
                    "message" => $e->getMessage()
                ]
            );
        }
    }
}
