<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\Informasi;
use App\Models\KategoriInformasi;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use Str;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:informasi-view|informasi-create|informasi-edit|informasi-show|informasi-delete', ['only' => ['index','store']]);
         $this->middleware('permission:informasi-view', ['only' => ['index']]);
         $this->middleware('permission:informasi-create', ['only' => ['create','store']]);
         $this->middleware('permission:informasi-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:informasi-show', ['only' => ['show']]);
         $this->middleware('permission:informasi-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('informasi-show');
            $canUpdate = Gate::allows('informasi-edit');
            $canDelete = Gate::allows('informasi-delete');
            $data = Informasi::with('Kategori')->get();
            return DataTables::of($data)
                    ->addColumn('kategori', function($data){
                        return $data->Kategori->nama_kategori;
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';
                        $url = route('informasi.edit',$data->id);

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="informasi/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('informasi-create');
        $name_page = "informasi";
        $title = "informasi";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::informasi.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $kategori = KategoriInformasi::all();
        $form = [
            0 => [
                "name" => "judul",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"judul",
                "value" =>""
            ],
            1 => [
                "name" => "content",
                "type" => "textarea",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Content",
                "value" =>""
            ],
            2 => [
                "name" => "kategoriinformasi_id",
                "type" => "select",
                "relasi" => $kategori,
                "col" => "s12",
                "data" => "",
                "placeholder" =>"Kategori",
                "value" =>"nama_kategori"
            ],

            3 => [
                "name" => "image",
                "type" => "file",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"image",
            ],
            4 => [
                "name" => "berkas",
                "type" => "file",
                "col" => "s6",
                "data" => "",
                "placeholder" =>"berkas",
            ],
          
        ];

        $name_page = "informasi";
        $title = "informasi";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'kategori'=>$kategori
        );

        return view('akademik::informasi.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'judul' => 'required',
                'content' => 'required',
                'image'     => 'required|image|mimes:png,jpg,jpeg',
                'berkas' => 'required|mimes:pdf|max:2048'
            ]);

           
     
            $save = new Informasi();
            $save->judul = $request->judul;
            $save->content = $request->content;
            $save->kategoriinformasi_id = $request->kategoriinformasi_id;
            $save->slug = Str::slug($request->slug);
            $save->image = $image ?? NULL;
            $save->berkas = $file ?? NULL;

            if ($request->file('image')) {
                $tujuan_upload = "image_informasi";
                $image = $request->file('image');
                $namareplace_ = str_replace(' ', '_', $image->getClientOriginalName());
                $nama_file = time() . "_" . $namareplace_;
                $image->move($tujuan_upload, $nama_file);
                $save->image = $nama_file;
            }

            if ($request->file('berkas')) {
                $tujuan_upload = "berkas";
                $image = $request->file('berkas');
                $namareplace_ = str_replace(' ', '_', $image->getClientOriginalName());
                $nama_file = time() . "_" . $namareplace_;
                $image->move($tujuan_upload, $nama_file);
                $save->berkas = $nama_file;
            }

            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('informasi.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('informasi.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $informasi = Informasi::findOrFail($id);
        $kategori = KategoriInformasi::all();
        $form = [
            0 => [
                "name" => "judul",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $informasi->judul,
                "placeholder" =>"judul",
                "value" => "judul"
            ],
            1 => [
                "name" => "content",
                "type" => "textarea",
                "relasi" => "",
                "col" => "s12",
                "data" => $informasi->content,
                "placeholder" =>"content",
                "value" => "content"
            ],
            2 => [
                "name" => "kategoriinformasi_id",
                "type" => "select",
                "relasi" => $kategori,
                "col" => "s12",
                "data" => $informasi->kategoriinformasi_id,
                "placeholder" =>"kategori informasi",
                "value" =>"nama_kategori"
            ],
            3 => [
                "name" => "image",
                "type" => "file",
                "relasi" => "",
                "col" => "s6",
                "data" => $informasi->image,
                "placeholder" =>"image",
                "value" => "image"
            ],
            4 => [
                "name" => "berkas",
                "type" => "file",
                "relasi" => "",
                "col" => "s6",
                "data" => $informasi->berkas,
                "placeholder" =>"berkas",
                "value" => "berkas"
            ],

          
        ];

        $name_page = "informasi";
        $title = "informasi";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'informasi'=>$informasi,
        );
        return view('akademik::informasi.edit')->with($data);
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
                'judul' => 'required',
                'content' => 'required',
            ]);

            $save = Informasi::findOrFail($id);
            $save->judul = $request->judul;
            $save->content = $request->content;
            $save->kategoriinformasi_id = $request->kategoriinformasi_id;
            $save->slug = Str::slug($request->judul);
            $save->save();

          

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('informasi.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('informasi.index')->with(['error' => 'Data Gagal Diubah!']);
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
           $delete =  Informasi::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("informasi.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("informasi.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
