<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JalurPendaftaran;
use Exception;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class JalurPendaftaranController extends Controller
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
         $this->middleware('permission:jalurpendaftaran-view|jalurpendaftaran-create|jalurpendaftaran-edit|jalurpendaftaran-show|jalurpendaftaran-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jalurpendaftaran-view', ['only' => ['index']]);
         $this->middleware('permission:jalurpendaftaran-create', ['only' => ['create','store']]);
         $this->middleware('permission:jalurpendaftaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jalurpendaftaran-show', ['only' => ['show']]);
         $this->middleware('permission:jalurpendaftaran-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('jalurpendaftaran-show');
            $canUpdate = Gate::allows('jalurpendaftaran-edit');
            $canDelete = Gate::allows('jalurpendaftaran-delete');
            $data = JalurPendaftaran::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jalurpendaftaran/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jalurpendaftaran/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('jalurpendaftaran-create');
        $name_page = "jalurpendaftaran";
        $title = "jalur pendaftaran";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::jalurpendaftaran.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "jalur_pendaftaran",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"jalur pendaftaran"
            ],
        ];

        $name_page = "jalurpendaftaran";
        $title = "jalur pendaftaran";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::jalurpendaftaran.create')->with($data);

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
                'jalur_pendaftaran' => 'required'
            ]);

            $save = new JalurPendaftaran();
            $save->jalur_pendaftaran = $request->jalur_pendaftaran;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jalurpendaftaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jalurpendaftaran.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $jalurpendaftaran = JalurPendaftaran::findOrFail($id);
        $form = [
            0 => [
                "name" => "jalur_pendaftaran",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $jalurpendaftaran->jalur_pendaftaran,
                "placeholder" =>"jalur pendaftaran"
            ],
        ];

        $name_page = "jalurpendaftaran";
        $title = "jalur pendaftaran";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'jalurpendaftaran' => $jalurpendaftaran
        );
        return view('akademik::jalurpendaftaran.edit')->with($data);
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
                'jalur_pendaftaran' => 'required'
            ]);

            $save = JalurPendaftaran::findOrFail($id);
            $save->jalur_pendaftaran = $request->jalur_pendaftaran;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jalurpendaftaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jalurpendaftaran.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  JalurPendaftaran::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("jalurpendaftaran.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("jalurpendaftaran.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
