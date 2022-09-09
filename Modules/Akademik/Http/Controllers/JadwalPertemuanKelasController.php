<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JadwalKelas;
use App\Models\JenisSemester;
use App\Models\Krs;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class JadwalPertemuanKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $jadwalpertemuan = JadwalKelas::where('ruangperkuliahan_id',$id)->get();
        return view('akademik::index', );
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
        $semesteraktif = JenisSemester::with('TahunAjaran')->where('active',1)->first();
        $peserta = Krs::with('mahasiswa')->where('kelas_id', $id)->where('jenissemester_id', $semesteraktif->id)->get();
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
