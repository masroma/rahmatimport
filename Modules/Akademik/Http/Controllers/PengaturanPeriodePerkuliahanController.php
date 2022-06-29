<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\PengaturanPeriodePerkuliahan;
use App\Models\Jurusan;
use App\Models\JenisSemester;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PengaturanPeriodePerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    protected $form;
    protected $pengaturanperiodeperkuliahan;
    protected $jurusan;
    protected $semester;
    protected $validate_params = [
        'programstudy_id'=>'required',
        'semester_id'=>'required',
        'target_mahasiswa_baru'=>'required',
        'pendaftar_ikut_seleksi'=>'required',
        'pendaftar_lulus_seleksi'=>'required',
        'pendaftar_daftar_ulang'=>'required',
        'pendaftar_mengundurkan_diri'=>'required',
        'jumlah_pertemuan'=>'required',
        'awal_perkuliahan'=>'required',
        'akhir_perkuliahan'=>'required',
    ];
    use ValidatesRequests;
    function __construct()
    {

         $this->middleware('permission:pengaturanperiodeperkuliahan-view|pengaturanperiodeperkuliahan-create|pengaturanperiodeperkuliahan-edit|pengaturanperiodeperkuliahan-show|pengaturanperiodeperkuliahan-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pengaturanperiodeperkuliahan-view', ['only' => ['index']]);
         $this->middleware('permission:pengaturanperiodeperkuliahan-create', ['only' => ['create','store']]);
         $this->middleware('permission:pengaturanperiodeperkuliahan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pengaturanperiodeperkuliahan-show', ['only' => ['show']]);
         $this->middleware('permission:pengaturanperiodeperkuliahan-delete', ['only' => ['destroy']]);

    }

    public function setform()
    {
        $this->form = [
            [
                "name" => "programstudy_id",
                "type" => "select",
                "relasi" => $this->jurusan??[],
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->programstudy_id??'',
                "placeholder" =>"Program Study",
                "value" =>"nama"
            ],
            [
                "name" => "semester_id",
                "type" => "select",
                "relasi" => $this->semester??[],
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->semester_id??'',
                "placeholder" =>"Jenis Semester",
                "value" =>"nama"
            ],
            [
                "name" => "target_mahasiswa_baru",
                "type" => "number",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->target_mahasiswa_baru??'',
                "placeholder" =>"Target Mahasiswa Baru",
            ],
            [
                "name" => "pendaftar_ikut_seleksi",
                "type" => "number",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->pendaftar_ikut_seleksi??'',
                "placeholder" =>"Pendaftar Ikut Seleksi",
            ],
            [
                "name" => "pendaftar_lulus_seleksi",
                "type" => "number",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->pendaftar_lulus_seleksi??'',
                "placeholder" =>"Pendaftar Lulus Seleksi",
            ],
            [
                "name" => "pendaftar_daftar_ulang",
                "type" => "number",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->pendaftar_daftar_ulang??'',
                "placeholder" =>"Pendaftar Daftar Ulang",
            ],
            [
                "name" => "pendaftar_mengundurkan_diri",
                "type" => "number",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->pendaftar_mengundurkan_diri??'',
                "placeholder" =>"Pendaftar Mengundurkan Diri",
            ],
            [
                "name" => "jumlah_pertemuan",
                "type" => "number",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->jumlah_pertemuan??'',
                "placeholder" =>"Jumlah Pertemuan",
            ],
            [
                "name" => "awal_perkuliahan",
                "type" => "date",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->awal_perkuliahan??'',
                "placeholder" =>"Tanggal Awal Perkuliahan",
            ],
            [
                "name" => "akhir_perkuliahan",
                "type" => "date",
                "col" => "s6",
                "data" => $this->pengaturanperiodeperkuliahan->akhir_perkuliahan??'',
                "placeholder" =>"Tanggal Akhir Perkuliahan",
            ],
        ];
    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('pengaturanperiodeperkuliahan-show');
            $canUpdate = Gate::allows('pengaturanperiodeperkuliahan-edit');
            $canDelete = Gate::allows('pengaturanperiodeperkuliahan-delete');
            $data = PengaturanPeriodePerkuliahan::with(['jurusan','semester'])->get();
            return DataTables::of($data)
                    ->addColumn('semester', function($data){
                        return $data->semester->jenis_semester .'-'. $data->semester->Tahunajaran->tahun_ajaran;
                    })
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="pengaturanperiodeperkuliahan/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="pengaturanperiodeperkuliahan/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('pengaturanperiodeperkuliahan-create');
        $name_page = "pengaturanperiodeperkuliahan";
        $title = "Pengaturan Periode Perkuliahan";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::pengaturanperiodeperkuliahan.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "pengaturanperiodeperkuliahan";
        $this->jurusan = Jurusan::all();
        $this->semester = JenisSemester::with('Tahunajaran')->get();
        $this->setform();

        $title = "Pengaturan Periode Perkuliahan";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'form' => $this->form,
        );

        return view('akademik::pengaturanperiodeperkuliahan.create')->with($data);
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
            $this->validate($request, $this->validate_params);
            $pengaturanperiodeperkuliahan = new PengaturanPeriodePerkuliahan();
            $params = array_filter(request()->all(),function($key) use ($pengaturanperiodeperkuliahan){
                return in_array($key,$pengaturanperiodeperkuliahan->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);

            $save = PengaturanPeriodePerkuliahan::create($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('pengaturanperiodeperkuliahan.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('pengaturanperiodeperkuliahan.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $this->pengaturanperiodeperkuliahan = PengaturanPeriodePerkuliahan::findOrFail($id);
        $this->jurusan = Jurusan::all();
        $this->semester = JenisSemester::with('Tahunajaran')->get();
        $this->setform();
        $name_page = "pengaturanperiodeperkuliahan";
        $title = "Program study";
        $data = array(
            'page' => $name_page,
            'pengaturanperiodeperkuliahan' => $this->pengaturanperiodeperkuliahan,
            'title' => $title,
            'form'=>$this->form,
            'jurusan' => $this->jurusan
        );
        return view('akademik::pengaturanperiodeperkuliahan.edit')->with($data);
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
            $this->validate($request, $this->validate_params);

            $pengaturanperiodeperkuliahan = new PengaturanPeriodePerkuliahan();
            $params = array_filter(request()->all(),function($key) use ($pengaturanperiodeperkuliahan){
                return in_array($key,$pengaturanperiodeperkuliahan->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);

            $update = PengaturanPeriodePerkuliahan::where('id',$id)->update($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('pengaturanperiodeperkuliahan.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('pengaturanperiodeperkuliahan.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        PengaturanPeriodePerkuliahan::find($id)->delete();
        return redirect()->route('pengaturanperiodeperkuliahan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
