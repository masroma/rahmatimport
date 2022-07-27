<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasKuliahMahasiswa;
use App\Models\JenisSemester;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class HitungAktivitasMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    public function data()
    {
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            $semester = JenisSemester::orderBy('id','DESC')->pluck('id')->first();
            
            $data = Mahasiswa::with(['totalKrs','Krs' => function($a) use($semester){
                $a->where('jenissemester_id',$semester);
            }])
            ->whereHas('Krs',function($a) use($semester){
                $a->where('jenissemester_id',$semester);
            })
           ->SELECT('*')
            ->get();
            // $data = Mahasiswa::with(['totalKrs'])
            // ->get();
            return DataTables::of($data)
                    ->addColumn('total_sks', function($data){
                        $totalBobot = 0;
                       foreach($data->totalkrs as $row){
                          $totalBobot += $row->matakuliah->bobot_mata_kuliah;
                       }
                       return number_format($totalBobot, 2, '.', '');
                    })
                    ->addColumn('total_sks_semester', function($data){
                        $totalBobotSemester = 0;
                        foreach($data->Krs as $row){
                            $totalBobotSemester += $row->matakuliah->bobot_mata_kuliah;
                        }
                        return number_format($totalBobotSemester, 2, '.', '');
                    })
                    ->addColumn('action', function ($data) {

                        $btn = '';

                        $btn .= '<a class="waves-effect green waves-light btn modal-trigger mr-2"onClick="detailKrs('.$data->id.')" href="#modal1">Detail KRS</a>';

                    

                        // if ($canUpdate) {
                        //     $btn .= '<a class="btn-floating btn-small mr-2" href="aktivitaskuliahmahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        // }

                        // if ($canDelete) {
                        //     $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        // }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="aktivitaskuliahmahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        // }

                        return $btn;

                        
                    })
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function dataKrs($id){
        try {
            // $canShow = Gate::allows('typemahasiswa-show');
            $canUpdate = Gate::allows('statusmahasiswa-edit');
            $canDelete = Gate::allows('statusmahasiswa-delete');
            $semester = JenisSemester::orderBy('id','DESC')->pluck('id')->first();
            
            $data = Krs::with('Matakuliah')->where('jenissemester_id', $semester)->where('mahasiswa_id', $id)->get();
         
            return DataTables::of($data)

                 
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ]
            );
        }
    }
    
    public function index()
    {
        $canCreate = Gate::allows('aktivitaskuliahmahasiswa-create');
        $name_page = "hitungaktivitaskmahasiswa";
        $title = "Hitung aktivitas kuliah mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::hitungakm.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('akademik::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('akademik::show');
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
        //
    }
}
