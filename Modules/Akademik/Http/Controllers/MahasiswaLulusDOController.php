<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\MahasiswaLulusDO;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\JenisSemester;
use App\Models\JenisKeluar;
use App\Models\CalculateIpsIpk;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MahasiswaLulusDOController extends Controller
{
    protected $form;
    protected $mahasiswalulusdo;
    protected $mahasiswa;
    protected $jenis_keluar;
    protected $jenis_semester;
    protected $validate_params = [
        'mahasiswa_id'=>'required',
        'jeniskeluar_id'=>'required',
        'tanggal_keluar'=>'required',
        'jenissemester_id'=>'required',
        'tanggal_sk'=>'required',
        'nomor_sk'=>'required',
        'ipk'=>'required',
        'no_ijazah'=>'required',
    ];
    use ValidatesRequests;
    function __construct()
    {
        //  $this->middleware('permission:mahasiswalulusdo-view|mahasiswalulusdo-create|mahasiswalulusdo-edit|mahasiswalulusdo-show|mahasiswalulusdo-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:mahasiswalulusdo-view', ['only' => ['index']]);
        //  $this->middleware('permission:mahasiswalulusdo-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:mahasiswalulusdo-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:mahasiswalulusdo-show', ['only' => ['show']]);
        //  $this->middleware('permission:mahasiswalulusdo-delete', ['only' => ['destroy']]);

    }

    public function setform()
    {
        $this->form = [
            [
                "name" => "mahasiswa_id",
                "type" => "select",
                "relasi" => $this->mahasiswa->toArray()??[],
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->mahasiswa_id??'',
                "placeholder" =>"Mahasiswa",
                "id"=>"id",
                "select_name"=>"nama"
            ],
            [
                "name" => "jeniskeluar_id",
                "type" => "select",
                "relasi" => $this->jenis_keluar->toArray()??[],
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->jeniskeluar_id??'',
                "placeholder" =>"Jenis Keluar",
                "id"=>"id",
                "select_name"=>"jenis_keluar"
            ],
            [
                "name" => "tanggal_keluar",
                "type" => "date",
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->tanggal_keluar??'',
                "placeholder" =>"Tanggal Keluar",
            ],
            [
                "name" => "jenissemester_id",
                "type" => "select",
                "relasi" => $this->jenis_semester??[],
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->jenissemester_id??'',
                "placeholder" =>"Periode Keluar",
                "id"=>"id",
                "select_name"=>"jenis_semester"
            ],
            [
                "name" => "tanggal_sk",
                "type" => "date",
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->tanggal_sk??'',
                "placeholder" =>"Tanggal SK",
            ],
            [
                "name" => "nomor_sk",
                "type" => "text",
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->nomor_sk??'',
                "placeholder" =>"Nomor SK",
            ],
            [
                "type" => "transkrip",
                "data" => $this->mahasiswalulusdo->mahasiswa_id??'',
            ],
            [
                "name" => "ipk",
                "type" => "number",
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->ipk??'',
                "placeholder" =>"IPK",
            ],
            [
                "name" => "keterangan",
                "type" => "textarea",
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->keterangan??'',
                "placeholder" =>"Keterangan",
            ],
            [
                "name" => "no_ijazah",
                "type" => "text",
                "col" => "s6",
                "data" => $this->mahasiswalulusdo->no_ijazah??'',
                "placeholder" =>"Nomor Ijazah",
            ],
        ];
    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('mahasiswalulusdo-show');
            // $canUpdate = Gate::allows('mahasiswalulusdo-edit');
            // $canDelete = Gate::allows('mahasiswalulusdo-delete');
            $canUpdate = true;
            $canDelete = true;
            $data = MahasiswaLulusDO::with(['mahasiswa'=>function($q){
                $q->with(['Riwayatpendidikan'=>function($e){
                    $e->with(['Programstudy'=>function($d){
                        $d->with('jurusan');
                    }]);
                }]);
            },'jenis_keluar','jenis_semester'])->get();
            return DataTables::of($data)
                    ->addColumn('periode_keluar',function($data){
                        return $data->jenis_semester->jenis_semester.' '.$data->jenis_semester->Tahunajaran->tahun_ajaran;
                    })
                    ->addColumn('jurusan',function($data){
                        return $data->mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan;
                    })
                    ->addColumn('angkatan',function($data){
                        return date('Y',strtotime($data->mahasiswa->Riwayatpendidikan->tanggal_masuk));
                    })
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="mahasiswalulusdo/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="mahasiswalulusdo/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        // $canCreate = Gate::allows('mahasiswalulusdo-create');
        $canCreate = true;
        $name_page = "mahasiswalulusdo";
        $title = "Mahasiswa Lulus / Drop Out";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::mahasiswalulusdo.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "mahasiswalulusdo";
        $this->mahasiswa = Mahasiswa::get();
        $this->jenis_keluar = JenisKeluar::get();
        $this->jenis_semester = JenisSemester::with('Tahunajaran')->get();
        $this->setform();

        $title = "Mahasiswa Lulus / Drop Out";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'mahasiswa' => $this->mahasiswa,
            'form' => $this->form,
        );

        return view('akademik::mahasiswalulusdo.create')->with($data);
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
            $mahasiswalulusdo = new MahasiswaLulusDO();
            $params = array_filter(request()->all(),function($key) use ($mahasiswalulusdo){
                return in_array($key,$mahasiswalulusdo->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);

            $save = MahasiswaLulusDO::create($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('mahasiswalulusdo.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('mahasiswalulusdo.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $this->mahasiswalulusdo = MahasiswaLulusDO::findOrFail($id);
        $this->mahasiswa = Mahasiswa::get();
        $this->jenis_keluar = JenisKeluar::get();
        $this->jenis_semester = JenisSemester::with('Tahunajaran')->get();
        $this->setform();
        $name_page = "mahasiswalulusdo";
        $title = "Program study";
        $data = array(
            'page' => $name_page,
            'mahasiswalulusdo' => $this->mahasiswalulusdo,
            'title' => $title,
            'form'=>$this->form,
            'mahasiswa' => $this->mahasiswa
        );
        return view('akademik::mahasiswalulusdo.edit')->with($data);
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

            $mahasiswalulusdo = new MahasiswaLulusDO();
            $params = array_filter(request()->all(),function($key) use ($mahasiswalulusdo){
                return in_array($key,$mahasiswalulusdo->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);

            $update = MahasiswaLulusDO::where('id',$id)->update($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('mahasiswalulusdo.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('mahasiswalulusdo.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        MahasiswaLulusDO::find($id)->delete();
        return redirect()->route('mahasiswalulusdo.index')
            ->with('success', 'Data berhasil dihapus');
    }
    public function getIpk($id)
    {
        return response()->json(CalculateIpsIpk::where('mahasiswa_id',$id)->orderBy('semester_id','desc')->pluck('ipk')->first());
    }
}
