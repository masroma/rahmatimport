<?php

namespace Modules\Mahasiswa\Http\Controllers;

use App\Models\JenisSemester;
use App\Models\Kurikulum;
use App\Models\KurikulumMatakuliah;
use App\Models\MataKuliah;
use App\Models\RuangPerkuliahan;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Illuminate\Foundation\Validation\ValidatesRequests;

class InformasiMatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:informasimatakuliah-view|informasimatakuliah-create|informasimatakuliah-edit|informasimatakuliah-show|informasimatakuliah-delete', ['only' => ['index','store']]);
         $this->middleware('permission:informasimatakuliah-view', ['only' => ['index']]);
         $this->middleware('permission:informasimatakuliah-create', ['only' => ['create','store']]);
         $this->middleware('permission:informasimatakuliah-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:informasimatakuliah-show', ['only' => ['show']]);
         $this->middleware('permission:informasimatakuliah-delete', ['only' => ['destroy']]);

    }


    public function index()
    {
        $mahasiswa = User::with('mahasiswa.Riwayatpendidikan.Programstudy.jenjang','mahasiswa.Riwayatpendidikan.Programstudy.jurusan')->findOrFail(Auth::user()->id);
        $programstudyid = $mahasiswa->mahasiswa->riwayatpendidikan->programstudy->id;
        $matakuliahkurikulum = Kurikulum::with(['matakuliah.matakuliah.Jenismatakuliah','matakuliah.matakuliah.kelas','matakuliahsemester' => function($q) {
            $q->groupBy('semester');
        }])->where('programstudy_id',$programstudyid)->first();
      
        return view('mahasiswa::informasimatakuliah.index',compact('matakuliahkurikulum'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('mahasiswa::create');
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
        $data = Crypt::decrypt($id);
        
        $id = $data[0];
        
        $perkuliahan = RuangPerkuliahan::with('kelasperkuliahan','kelasperkuliahan.programstudy.jurusan','Ruang.ListKampus')->where('kelasperkuliahan_id', $id)->where('ruang_id',1)->first();
        // dd($perkuliahan->kelasperkuliahan);
        $uts = RuangPerkuliahan::with('kelasperkuliahan','Ruang.ListKampus')->where('kelasperkuliahan_id', $id)->where('ruang_id',2)->first();
        $uas = RuangPerkuliahan::with('kelasperkuliahan','Ruang.ListKampus')->where('kelasperkuliahan_id', $id)->where('ruang_id',3)->first();
        
        return view('mahasiswa::informasimatakuliah.show',compact('perkuliahan','uts','uas','data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('mahasiswa::edit');
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

    public function cetak(){
        $mahasiswa = User::with('mahasiswa.Riwayatpendidikan.Programstudy.jenjang','mahasiswa.Riwayatpendidikan.Programstudy.jurusan','mahasiswa.Riwayatpendidikan.Kampus')->findOrFail(Auth::user()->id);

        // dd($mahasiswa->mahasiswa->Riwayatpendidikan->Kampus);
       
        $programstudyid = $mahasiswa->mahasiswa->riwayatpendidikan->programstudy->id;
        $matakuliahkurikulum = Kurikulum::with(['matakuliah.matakuliah.Jenismatakuliah','matakuliah.matakuliah.kelas','matakuliahsemester' => function($q) {
            $q->groupBy('semester');
        }])->where('programstudy_id',$programstudyid)->first();

        $semester = JenisSemester::with('TahunAjaran')->orderByDesc('id')->first();
        
        $data = [
            'matakuliahkurikulum' => $matakuliahkurikulum,
            'mahasiswa' => $mahasiswa,
            'semester' => $semester
        ];

        $pdf = PDF::loadView('mahasiswa::informasimatakuliah.cetak', $data);

     

        return $pdf->download('listmatakuliah.pdf');
       
       
        // return view('mahasiswa::informasimatakuliah.cetak',compact('matakuliahkurikulum','mahasiswa','semester'));
    }
}
