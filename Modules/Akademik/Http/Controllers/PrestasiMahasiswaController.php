<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\AktivitasMahasiswa;
use App\Models\JenisPrestasi;
use App\Models\Mahasiswa;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\prestasimahasiswa;
use App\Models\TingkatPrestasi;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PrestasiMahasiswaController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */
     /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
        //  $this->middleware('permission:prestasimahasiswa-view|prestasimahasiswa-create|prestasimahasiswa-edit|prestasimahasiswa-show|prestasimahasiswa-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:prestasimahasiswa-view', ['only' => ['index']]);
        //  $this->middleware('permission:prestasimahasiswa-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:prestasimahasiswa-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:prestasimahasiswa-show', ['only' => ['show']]);
        //  $this->middleware('permission:prestasimahasiswa-delete', ['only' => ['destroy']]);

    }

    public function data($id)
    {
        try {
            // $canShow = Gate::allows('prestasimahasiswa-show');
            $canUpdate = Gate::allows('prestasimahasiswa-edit');
            $canDelete = Gate::allows('prestasimahasiswa-delete');
            $data = PrestasiMahasiswa::with('Mahasiswa','JenisPrestasi','TingkatPrestasi','AktivitasMahasiswa')->where('mahasiswa_id',$id)->get(); //query
            return DataTables::of($data)
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="prestasimahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="prestasimahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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

    public function index()
    {
        $canCreate = Gate::allows('prestasimahasiswa-create');
        $name_page = "prestasimahasiswa";
        $title = "prestasi mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::prestasimahasiswa.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id){
    $aktivitasmahasiswa = AktivitasMahasiswa::all();
    $jenisprestasi = JenisPrestasi::all();
    $tingkatprestasi = TingkatPrestasi::all();
        $form = [
             0 => [
                "name" => "aktivitasmahasiswa_id",
                "type" => "select",
                "relasi" => $aktivitasmahasiswa,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"aktivitas mahasiswa",
                "value" => "judul"
            ],
            1 => [
                "name" => "jenisprestasi_id",
                "type" => "select",
                "relasi" => $jenisprestasi,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"jenis prestasi",
                "value" => "jenis_prestasi"
            ],
            2 => [
                "name" => "tingkatprestasi_id",
                "type" => "select",
                "relasi" => $tingkatprestasi,
                "col" => "s6",
                "data" => "",
                "placeholder" =>"tingkat prestasi",
                "value" => "tingkat_prestasi"
            ],
            3 => [
                "name" => "nama_prestasi",
                "type" => "text",
                "relasi" => "",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"nama prestasi"
            ],
            4 => [
                "name" => "tahun_prestasi",
                "type" => "text",
                "relasi" => "",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"tahun prestasi"
            ],
            5 => [
                "name" => "penyelenggara",
                "type" => "text",
                "relasi" => "",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"penyelenggara"
            ],
            6 => [
                "name" => "peringkat",
                "type" => "number",
                "relasi" => "",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"peringkat"
            ],
            7 => [
                "name" => "mahasiswa_id",
                "type" => "hidden",
                "relasi" => "",
                "col" => "s6",
                "data" => $id,
                "placeholder" =>"mahasiswa id"
            ],

            
        ];

        $name_page = "mahasiswa";
        $title = "prestasi mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title
        );

        return view('akademik::prestasimahasiswa.create')->with($data);

    }

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
                'aktivitasmahasiswa_id' => 'required',
                'jenisprestasi_id' => 'required',
                'tingkatprestasi_id' => 'required',
                'nama_prestasi' => 'required',
                'tahun_prestasi' => 'required',
                'penyelenggara' => 'required',
                'peringkat' => 'required'
            ]);

            $save = new PrestasiMahasiswa();
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->aktivitasmahasiswa_id = $request->aktivitasmahasiswa_id;
            $save->tingkatprestasi_id = $request->tingkatprestasi_id;
            $save->nama_prestasi = $request->nama_prestasi;
            $save->tahun_prestasi = $request->tahun_prestasi;
            $save->penyelenggara = $request->penyelenggara;
            $save->peringkat = $request->peringkat;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('prestasimahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('prestasimahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
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
        $aktivitasmahasiswa = AktivitasMahasiswa::all();
        $jenisprestasi = JenisPrestasi::all();
        $tingkatprestasi = TingkatPrestasi::all();
        $prestasimahasiswa = PrestasiMahasiswa::findOrFail($id);
        $form = [
          
            0 => [
                "name" => "aktivitasmahasiswa_id",
                "type" => "select",
                "relasi" => $aktivitasmahasiswa,
                "col" => "s6",
                "data" => $prestasimahasiswa->aktivitasmahasiswa_id,
                "placeholder" =>"aktivitas mahasiswa",
                "value" => "judul"
            ],
            1 => [
                "name" => "jenisprestasi_id",
                "type" => "select",
                "relasi" => $jenisprestasi,
                "col" => "s6",
                "data" => $prestasimahasiswa->jenisprestasi_id,
                "placeholder" =>"jenis prestasi",
                "value" => "jenis_prestasi"
            ],
            2 => [
                "name" => "tingkatprestasi_id",
                "type" => "select",
                "relasi" => $tingkatprestasi,
                "col" => "s6",
                "data" => $prestasimahasiswa->tingkatprestasi_id,
                "placeholder" =>"tingkat prestasi",
                "value" => "tingkat_prestasi"
            ],
            3 => [
                "name" => "nama_prestasi",
                "type" => "text",
                "relasi" => "",
                "col" => "s6",
                "data" => $prestasimahasiswa->nama_prestasi,
                "placeholder" =>"nama prestasi"
            ],
            4 => [
                "name" => "tahun_prestasi",
                "type" => "text",
                "relasi" => "",
                "col" => "s6",
                "data" => $prestasimahasiswa->tahun_prestasi,
                "placeholder" =>"tahun prestasi"
            ],
            5 => [
                "name" => "penyelenggara",
                "type" => "text",
                "relasi" => "",
                "col" => "s6",
                "data" => $prestasimahasiswa->penyelenggara,
                "placeholder" =>"penyelenggara"
            ],
            6 => [
                "name" => "peringkat",
                "type" => "number",
                "relasi" => "",
                "col" => "s6",
                "data" => $prestasimahasiswa->pringkat,
                "placeholder" =>"peringkat"
            ],
            7 => [
                "name" => "mahasiswa_id",
                "type" => "hidden",
                "relasi" => "",
                "col" => "s6",
                "data" => $id,
                "placeholder" =>"mahasiswa_id"
            ],

        ];

        $name_page = "mahasiswa";
        $title = "prestasi mahasiswa";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'prestasimahasiswa' => $prestasimahasiswa
        );
        return view('akademik::prestasimahasiswa.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'aktivitasmahasiswa_id' => 'required',
                'jenisprestasi_id' => 'required',
                'tingkatprestasi_id' => 'required',
                'nama_prestasi' => 'required',
                'tahun_prestasi' => 'required',
                'penyelenggara' => 'required',
                'peringkat' => 'required'
            ]);

            $save = new PrestasiMahasiswa();
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->aktivitasmahasiswa_id = $request->aktivitasmahasiswa_id;
            $save->tingkatprestasi_id = $request->tingkatprestasi_id;
            $save->nama_prestasi = $request->nama_prestasi;
            $save->tahun_prestasi = $request->tahun_prestasi;
            $save->penyelenggara = $request->penyelenggara;
            $save->peringkat = $request->peringkat;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('prestasimahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('prestasimahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
           $delete =  PrestasiMahasiswa::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("prestasimahasiswa.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("prestasimahasiswa.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
