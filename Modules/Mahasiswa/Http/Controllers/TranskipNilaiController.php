<?php

namespace Modules\Mahasiswa\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\SkalaNilai;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Carbon\Carbon;
use DataTables;
use Exception;
use Gate;
use DB;
use PDF;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TranskipNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;


    function __construct()
    {
         $this->middleware('permission:transkipnilai-view|transkipnilai-create|transkipnilai-edit|transkipnilai-show|transkipnilai-delete', ['only' => ['index','store']]);
         $this->middleware('permission:transkipnilai-view', ['only' => ['index']]);
         $this->middleware('permission:transkipnilai-create', ['only' => ['create','store']]);
         $this->middleware('permission:transkipnilai-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:transkipnilai-show', ['only' => ['show']]);
         $this->middleware('permission:transkipnilai-delete', ['only' => ['destroy']]);

    }
    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $mahasiswa = Mahasiswa::with('Riwayatpendidikan.JenisSemester','Riwayatpendidikan.ProgramStudy.jurusan','Riwayatpendidikan.ProgramStudy.jenjang')->findOrFail($user->relation_id);
        $semester = Krs::with('jenissemester.tahunajaran','NilaiIps')->where('mahasiswa_id',$user->relation_id)->latest()->first();
        $skalanilai = SkalaNilai::where('programstudy_id', $mahasiswa->Riwayatpendidikan->ProgramStudy->id)->get();
       
        $krs = Krs::with('NilaiKrs','Matakuliah')->where('mahasiswa_id',$user->relation_id)->get();
        // dd($krs);
        return view('mahasiswa::transkipnilai.index',compact('semester','krs','user','mahasiswa','skalanilai'));
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
