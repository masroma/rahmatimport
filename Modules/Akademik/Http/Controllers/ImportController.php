<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportMahasiswa;
use App\Imports\ImportDosen;
use App\Imports\ImportSemester;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($data,$page)
    {
        return view('akademik::import.index',compact('data','page'));
    }
    public function mahasiswa()
    {
        $page = "Import Mahasiswa";
        $data = [
            'module'=>'mahasiswa',
            'action'=>route('import.mahasiswa'),
            'template'=>'/template/excel/template_mahasiswa.xlsx'
        ];
        return $this->index($data,$page);
    }
    public function dosen()
    {
        $page = "Import Dosen";
        $data = [
            'module'=>'dosen',
            'action'=>route('import.dosen'),
            'template'=>'/template/excel/template_dosen.xlsx'
        ];
        return $this->index($data,$page);
    }

    public function semester()
    {
        $page = "Import Semester";
        $data = [
            'module'=>'semester',
            'action'=>route('import.semester'),
            'template'=>'/template/excel/template_semester.xlsx'
        ];
        return $this->index($data,$page);
    }

    public function importMahasiswa(Request $request)
    {
        try{
            $import = Excel::import(new ImportMahasiswa, $request->excel_file);
            return redirect()->route('mahasiswa.index')->with(['success' => 'Import Berhasi']);

        }catch(\Exception $e){
            return redirect()->route('mahasiswa.index')->with(['error' => 'Import Gagal']);
        }

        return redirect()->route('mahasiswa.index')->with(['error' => 'Import Gagal']);
    }

    public function importDosen(Request $request)
    {
        try{
            $import = Excel::import(new ImportDosen, $request->excel_file);
            return redirect()->route('dosen.index')->with(['success' => 'Import Berhasi']);

        }catch(\Exception $e){
            return redirect()->route('dosen.index')->with(['error' => 'Import Gagal, '.$e->getMessage()??'']);
        }

        return redirect()->route('dosen.index')->with(['error' => 'Import Gagal']);
    }

    public function importSemester(Request $request)
    {
        try{
            $import = Excel::import(new ImportSemester, $request->excel_file);
            return redirect()->route('index.semester')->with(['success' => 'Import Berhasi']);

        }catch(\Exception $e){
            return redirect()->route('index.semester')->with(['error' => 'Import Gagal, '.$e->getMessage()??'']);
        }

        return redirect()->route('index.semester')->with(['error' => 'Import Gagal']);
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
