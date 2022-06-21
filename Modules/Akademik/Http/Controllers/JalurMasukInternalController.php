<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\JalurMasukInternal;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class JalurMasukInternalController extends Controller
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
         $this->middleware('permission:jalurmasuk-view|jalurmasuk-create|jalurmasuk-edit|jalurmasuk-show|jalurmasuk-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jalurmasuk-view', ['only' => ['index']]);
         $this->middleware('permission:jalurmasuk-create', ['only' => ['create','store']]);
         $this->middleware('permission:jalurmasuk-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jalurmasuk-show', ['only' => ['show']]);
         $this->middleware('permission:jalurmasuk-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('jalurmasuk-show');
            $canUpdate = Gate::allows('jalurmasuk-edit');
            $canDelete = Gate::allows('jalurmasuk-delete');
            $data = JalurMasukInternal::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jalurmasuk/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jalurmasuk/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('jalurmasuk-create');
        $name_page = "jalurmasuk";
        $title = "jalur masuk internal";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::jalurmasuk.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "nama_jalur",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"nama jalur"
            ],
        ];

        $name_page = "jalurmasuk";
        $title = "jalur masuk internal";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::jalurmasuk.create')->with($data);

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
                'nama_jalur' => 'required'
            ]);

            $save = new JalurMasukInternal();
            $save->nama_jalur = $request->nama_jalur;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jalurmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jalurmasuk.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $jalurmasukinternal = JalurMasukInternal::findOrFail($id);
        $form = [
            0 => [
                "name" => "nama_jalur",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $jalurmasukinternal->nama_jalur,
                "placeholder" =>"nama jalur"
            ],
        ];

        $name_page = "jalurmasuk";
        $title = "jalur masuk internal";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'jalurmasukinternal' =>  $jalurmasukinternal
        );
        return view('akademik::jalurmasuk.edit')->with($data);
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
                'nama_jalur' => 'required'
            ]);

            $save = JalurMasukInternal::findOrFail($id);
            $save->nama_jalur = $request->nama_jalur;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jalurmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jalurmasuk.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  JalurMasukInternal::find($id)->delete();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("jalurmasuk.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("jalurmasuk.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
