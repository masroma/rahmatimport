<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    protected $importClass = [
        'mahasiswa'=>'App\Imports\ImportMahasiswa',
        'dosen'=>'App\Imports\ImportDosen',
        'semester'=>'App\Imports\ImportSemester',
        'matakuliah'=>'App\Imports\ImportMataKuliah',
    ];
    public function index($data,$page)
    {
        return view('akademik::import.index',compact('data','page'));
    }
    public function mahasiswa()
    {
        $page = "Import Mahasiswa";
        $data = [
            'module'=>'mahasiswa',
            'template'=>'/template/excel/template_mahasiswa.xlsx',
            'redirect'=>'mahasiswa.index'
        ];
        return $this->index($data,$page);
    }
    public function dosen()
    {
        $page = "Import Dosen";
        $data = [
            'module'=>'dosen',
            'template'=>'/template/excel/template_dosen.xlsx',
            'redirect'=>'dosen.index'
        ];
        return $this->index($data,$page);
    }
    public function matakuliah()
    {
        $page = "Import Mata Kuliah";
        $data = [
            'module'=>'matakuliah',
            'template'=>'/template/excel/template_mata_kuliah.xlsx',
            'redirect'=>'matakuliah.index'
        ];
        return $this->index($data,$page);
    }

    public function semester()
    {
        $page = "Import Semester";
        $data = [
            'module'=>'semester',
            'template'=>'/template/excel/template_semester.xlsx',
            'redirect'=>'tahunajaran.index'
        ];
        return $this->index($data,$page);
    }

    public function importProcess(Request $request)
    {
        $this->validate($request, [
            'excel_file' => 'required',
        ]);
        try{
            $import = Excel::import(new $this->importClass[$request->module], $request->excel_file);
            return redirect()->route($request->redirect)->with(['success' => 'Import Berhasi']);

        }catch(\Exception $e){
            return redirect()->route($request->redirect)->with(['error' => 'Import Gagal, '.$e->getMessage()??'']);
        }

        return redirect()->route($request->redirect)->with(['error' => 'Import Gagal']);
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
