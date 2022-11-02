<?php

namespace Modules\Akademik\Http\Controllers;

use App\Models\JatahKrs;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class JatahKrsController extends Controller
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
         $this->middleware('permission:jatahkrs-view|jatahkrs-create|jatahkrs-edit|jatahkrs-show|jatahkrs-delete', ['only' => ['index','store']]);
         $this->middleware('permission:jatahkrs-view', ['only' => ['index']]);
         $this->middleware('permission:jatahkrs-create', ['only' => ['create','store']]);
         $this->middleware('permission:jatahkrs-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:jatahkrs-show', ['only' => ['show']]);
         $this->middleware('permission:jatahkrs-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            // $canShow = Gate::allows('jatahkrs-show');
            $canUpdate = Gate::allows('jatahkrs-edit');
            $canDelete = Gate::allows('jatahkrs-delete');
            $data = JatahKrs::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="jatahkrs/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        // if ($canShow) {
                        //     $btn .= '<a class="btn-floating green darken-1 btn-small" href="jatahkrs/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('jatahkrs-create');
        $name_page = "jatahkrs";
        $title = "jatah krs";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            "title" => $title
        );
        return view('akademik::jatahkrs.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $form = [
            0 => [
                "name" => "ip_min",
                "type" => "number",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"ip minimal"
            ],
            1 => [
                "name" => "ip_max",
                "type" => "number",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"ip maximal"
            ],
            2 => [
                "name" => "jumlah_sks",
                "type" => "number",
                "relasi" => "",
                "col" => "s12",
                "data" => "",
                "placeholder" =>"jumlah sks"
            ],
        ];

        $name_page = "jatahkrs";
        $title = "jatah krs";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title

        );

        return view('akademik::jatahkrs.create')->with($data);

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
                'ip_min' => 'required',
                'ip_max' => 'required',
                'jumlah_sks' => 'required'
            ]);

            $save = new JatahKrs();
            $save->ip_min = $request->ip_min;
            $save->ip_max = $request->ip_max;
            $save->jumlah_sks = $request->jumlah_sks;
            $save->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jatahkrs.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jatahkrs.index')->with(['error' => 'Data Gagal Disimpan!']);
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

        $jatahkrs = JatahKrs::findOrFail($id);
        $form = [

            0 => [
                "name" => "ip_min",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" => $jatahkrs->ip_min,
                "placeholder" =>"ip minimal"
            ],
            1 => [
                "name" => "ip_max",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" =>  $jatahkrs->ip_max,
                "placeholder" =>"ip maximal"
            ],
            2 => [
                "name" => "jumlah_sks",
                "type" => "text",
                "relasi" => "",
                "col" => "s12",
                "data" =>  $jatahkrs->jumlah_sks,
                "placeholder" =>"jumlah sks"
            ],
        ];

        // dd($form);
        $name_page = "jatahkrs";
        $title = "jatah krs";
        $data = array(
            'page' => $name_page,
            'form' => $form,
            'title' => $title,
            'jatahkrs' => $jatahkrs
        );
        return view('akademik::jatahkrs.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // DB::beginTransaction();
        // try {
            // $this->validate($request, [
            //     'ip_min' => 'required',
            //     'ip_max' => 'required',
            //     'jumlah_krs' => 'required'
            // ]);

            $save = JatahKrs::findOrFail($id);
            $save->ip_min = $request->ip_min;
            $save->ip_max = $request->ip_max;
            $save->jumlah_sks = $request->jumlah_sks;
            $save->update();

            DB::commit();
        // } catch (Exception $exception) {
        //     DB::rollback();
        //     return back()->with('error', $exception->getMessage());
        // }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('jatahkrs.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('jatahkrs.index')->with(['error' => 'Data Gagal Disimpan!']);
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
           $delete =  JatahKrs::find($id)->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route("jatahkrs.index")->with("success", "Data berhasil dihapus");
        } else {
            //redirect dengan pesan error
            return redirect()->route("jatahkrs.index")->with(["error" => "Data Gagal Dihapus!"]);
        }
    }
}
