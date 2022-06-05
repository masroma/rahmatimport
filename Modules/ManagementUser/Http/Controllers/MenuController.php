<?php

namespace Modules\ManagementUser\Http\Controllers;

use App\Models\AksesMenu;
use App\Models\Menu;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Auth;
use Gate;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
        //  $this->middleware('permission:menu-view|menu-create|menu-edit|menu-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:menu-view', ['only' => ['index']]);
        //  $this->middleware('permission:menu-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:menu-delete', ['only' => ['destroy']]);


    }

    public function data()
    {
        try {
            $canUpdate = Gate::allows('menu-edit');
            $canDelete = Gate::allows('menu-delete');
            $data = Menu::all();
            return DataTables::of($data)
                    ->addColumn('aksi', function($data){
                        return $data->action;
                    })
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="menu/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

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
        $canCreate = Gate::allows('menu-create');
        $name_page = "menu";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('managementuser::menu.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $keypermission = Permission::groupBy('key')->get();
        $parentmenu = Menu::where('position','parent')->get();
        $name_page = "menu";
        $data = array(
            'page' => $name_page,
            'parentmenu' => $parentmenu,
            'keypermission' => $keypermission
        );

        return view('managementuser::menu.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'link' => 'required',
            'icon' => 'required',
            'position' => 'required',
            'parent_id' => 'required',
            'key_permission' => 'required',
            // 'action' => 'required',
            'order' => 'required'
        ]);

        $save = new Menu();
        $save->name = $request->name;
        $save->link = $request->link;
        $save->icon = $request->icon;
        $save->position = $request->position ?? 'none';
        $save->parent_id = $request->parent_id ?? 0;
        $save->key_permission = $request->key_permission ?? 'none';
        $save->action = json_encode($request->get('action')) ?? null;
        $save->order = $request->order ?? 0;
        $save->save();
        // DB::commit();

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('menu.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('menu.index')->with(['error' => 'Data Gagal Disimpan!']);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('managementuser::menu.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $keypermission = Permission::groupBy('key')->get();
        $parentmenu = Menu::where('position','parent')->get();
        $menu = Menu::find($id);
        $name_page = "menu";
        $data = array(
            'page' => $name_page,
            'menu' => $menu,
            'keypermission' => $keypermission,
            'parentmenu' => $parentmenu
        );
        return view('managementuser::menu.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

            $this->validate($request, [
                'name' => 'required',
                'link' => 'required',
                'icon' => 'required',
                'position' => 'required',
                'parent_id' => 'required',
                'key_permission' => 'required',
                'action' => 'required',
                'order' => 'required'
            ]);

            $update = Menu::find($id);
            $update->name = $request->name;
            $update->link = $request->link;
            $update->icon = $request->icon;
            $update->position = $request->position ?? 'none';
            $update->parent_id = $request->parent_id ?? 0;
            $update->key_permission = $request->key_permission ?? 'none';
            $update->action = json_encode($request->get('action')) ?? null;
            $update->order = $request->order ?? 0;
            $update->save();


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('menu.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('menu.index')->with(['error' => 'Data Gagal Diubah!']);
            }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Menu::find($id)->delete();
        return redirect()->route('menu.index')
            ->with('success', 'Data berhasil dihapus');
    }


}
