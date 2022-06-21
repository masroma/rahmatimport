<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JenisPendaftaran;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
class JenisPendaftaranController extends Controller
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
         $this->middleware('permission:jenispendaftaran-view|jenispendaftaran-create|jenispendaftaran-edit|jenispendaftaran-show|jenispendaftaran-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jenispendaftaran-view', ['only' => ['index']]);
         $this->middleware('permission:jenispendaftaran-create', ['only' => ['create','store']]);
         $this->middleware('permission:jenispendaftaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jenispendaftaran-show', ['only' => ['show']]);
         $this->middleware('permission:jenispendaftaran-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('jenispendaftaran-show');
            $canUpdate = Gate::allows('jenispendaftaran-edit');
            $canDelete = Gate::allows('jenispendaftaran-delete');
            $data = JenisPendaftaran::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jenispendaftaran/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jenispendaftaran/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('jenispendaftaran-create');
        $name_page = "jenispendaftaran";
        $title = "jenis pendaftaran";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::jenispendaftaran.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "jenis_pendaftaran",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"jenis pendaftaran"
            ],
        ];

        $name_page = "jenispendaftaran";
        $title = "jenis pendaftaran";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::jenispendaftaran.create')->with($data);

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
                'jenis_pendaftaran' => 'required'
            ]);

            $save = new JenisPendaftaran();
            $save->jenis_pendaftaran = $request->jenis_pendaftaran;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jenispendaftaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jenispendaftaran.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $jenispendaftaran = JenisPendaftaran::findOrFail($id);
        $form = [
            0 => [
                "name" => "jenis_pendaftaran",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $jenispendaftaran->jenis_pendaftaran,
                "placeholder" =>"jenis pendaftaran"
            ],
        ];

        $name_page = "jenispendaftaran";
        $title = "jenis pendaftaran";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'jenispendaftaran' => $jenispendaftaran
        );
        return view('akademik::jenispendaftaran.edit')->with($data);
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
                'jenis_pendaftaran' => 'required'
            ]);

            $save = JenisPendaftaran::findOrFail($id);
            $save->jenis_pendaftaran = $request->jenis_pendaftaran;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jenispendaftaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jenispendaftaran.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  JenisPendaftaran::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("jenispendaftaran.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("jenispendaftaran.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
