<?php

namespace Modules\Mahasiswa\Http\Controllers;

use App\Models\JatahKrs;
use App\Models\JenisSemester;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function data()
    {
        $semester = JenisSemester::where('active',1)->first();
       
    }

    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $mahasiswa = Mahasiswa::with('Riwayatpendidikan.JenisSemester','Riwayatpendidikan.ProgramStudy.jurusan','Riwayatpendidikan.ProgramStudy.jenjang')->findOrFail($user->relation_id);
        $semester = JenisSemester::with('TahunAjaran')->where('active',1)->latest()->first();
        $semesterkemarin = $semester->id - 1;
        $krs = Krs::with('Mahasiswa','matakuliah','kelas')->where('jenissemester_id',$semester->id)->where('mahasiswa_id',$user->relation_id)->get();
        $krssemesterkemarin = Krs::with(['NilaiKrs' => function($q) use($user){
            return $q->where('mahasiswa_id',$user->relation_id);
        },'Mahasiswa.Riwayatpendidikan.ProgramStudy.jurusan.SkalaNilai','matakuliah','kelas'])->where('jenissemester_id',$semesterkemarin)->where('mahasiswa_id',$user->relation_id)->get();

        $no = 1; 
        $totalsks = 0;
        $totalip = 0;
        $totalnilaiindex = 0;

        foreach($krssemesterkemarin as $row){
                $totalsks += $row->matakuliah->bobot_mata_kuliah;
                foreach ($row->Mahasiswa->Riwayatpendidikan->ProgramStudy->jurusan->SkalaNilai as $sn) {
                    if($sn->nilai_huruf == $row->NilaiKrs->nilai_huruf){
                        $totalnilaiindex += $sn->nilai_index * $row->matakuliah->bobot_mata_kuliah;
                    }
                }
        }
        // dd($krssemesterkemarin);
        $ips= number_format($totalnilaiindex / $totalsks, 2);
        $jatahsks = JatahKrs::all();
       
        $sks = 0;
        foreach($jatahsks as $js){
            if($ips >= $js->ip_min && $ips <= $js->ip_max){
                $sks = $js->jumlah_sks;
            }
        }

        

        return view('mahasiswa::krs.index',compact('krs','semester','mahasiswa','krssemesterkemarin','ips','sks'));
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
        return view('mahasiswa::show');
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
}
