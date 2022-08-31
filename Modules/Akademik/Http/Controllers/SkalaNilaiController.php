<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\SkalaNilai;
use App\Models\Jurusan;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SkalaNilaiController extends Controller
{
    protected $form;
    protected $skalanilai;
    protected $jurusan;
    protected $validate_params = [
        'programstudy_id'=>'required',
        'nilai_huruf'=>'required',
        'nilai_index'=>'required',
        'bobot_min'=>'required',
        'bobot_max'=>'required',
        'tanggal_mulai'=>'required',
        'tanggal_akhir'=>'required',
    ];
    use ValidatesRequests;
    function __construct()
    {
         $this->middleware('permission:skalanilai-view|skalanilai-create|skalanilai-edit|skalanilai-show|skalanilai-delete', ['only' => ['index','store']]);
         $this->middleware('permission:skalanilai-view', ['only' => ['index']]);
         $this->middleware('permission:skalanilai-create', ['only' => ['create','store']]);
         $this->middleware('permission:skalanilai-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:skalanilai-show', ['only' => ['show']]);
         $this->middleware('permission:skalanilai-delete', ['only' => ['destroy']]);

    }

    public function setform()
    {
        $this->form = [
            [
                "name" => "programstudy_id",
                "type" => "select",
                "relasi" => $this->jurusan??[],
                "col" => "s12",
                "data" => $this->skalanilai->programstudy_id??'',
                "placeholder" =>"Program Study",
                "value" =>"nama"
            ],
            [
                "name" => "nilai_huruf",
                "type" => "text",
                "col" => "s6",
                "data" => $this->skalanilai->nilai_huruf??'',
                "placeholder" =>"Nilai Huruf",
            ],
            [
                "name" => "nilai_index",
                "type" => "number",
                "col" => "s6",
                "data" => $this->skalanilai->nilai_index??'',
                "placeholder" =>"Nilai Index",
            ],
            [
                "name" => "bobot_min",
                "type" => "number",
                "col" => "s6",
                "data" => $this->skalanilai->bobot_min??'',
                "placeholder" =>"Bobot Minimal",
            ],
            [
                "name" => "bobot_max",
                "type" => "number",
                "col" => "s6",
                "data" => $this->skalanilai->bobot_max??'',
                "placeholder" =>"Bobot Maksimal",
            ],
            [
                "name" => "tanggal_mulai",
                "type" => "date",
                "col" => "s6",
                "data" => $this->skalanilai->tanggal_mulai??'',
                "placeholder" =>"Tanggal Efektif Mulai",
            ],
            [
                "name" => "tanggal_akhir",
                "type" => "date",
                "col" => "s6",
                "data" => $this->skalanilai->tanggal_akhir??'',
                "placeholder" =>"Tanggal Efektif Akhir",
            ],
        ];
    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('skalanilai-show');
            $canUpdate = Gate::allows('skalanilai-edit');
            $canDelete = Gate::allows('skalanilai-delete');
            $data = SkalaNilai::with('jurusan')->get();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="skalanilai/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="skalanilai/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('skalanilai-create');
        $name_page = "skalanilai";
        $title = "Skala Nilai";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::skalanilai.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "skalanilai";
        $this->jurusan = Jurusan::all();
        $this->setform();

        $title = "Skala Nilai";
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'jurusan' => $this->jurusan,
            'form' => $this->form,
        );

        return view('akademik::skalanilai.create')->with($data);
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
            $skalanilai = new SkalaNilai();
            $params = array_filter(request()->all(),function($key) use ($skalanilai){
                return in_array($key,$skalanilai->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            $params['nilai_huruf']=strtoupper($params['nilai_huruf']);

            $save = SkalaNilai::create($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('skalanilai.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('skalanilai.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $this->skalanilai = SkalaNilai::findOrFail($id);
        $this->jurusan = Jurusan::all();
        $this->setform();
        $name_page = "skalanilai";
        $title = "Program study";
        $data = array(
            'page' => $name_page,
            'skalanilai' => $this->skalanilai,
            'title' => $title,
            'form'=>$this->form,
            'jurusan' => $this->jurusan
        );
        return view('akademik::skalanilai.edit')->with($data);
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

            $skalanilai = new SkalaNilai();
            $params = array_filter(request()->all(),function($key) use ($skalanilai){
                return in_array($key,$skalanilai->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);

            $update = SkalaNilai::where('id',$id)->update($params);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('skalanilai.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('skalanilai.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        SkalaNilai::find($id)->delete();
        return redirect()->route('skalanilai.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
