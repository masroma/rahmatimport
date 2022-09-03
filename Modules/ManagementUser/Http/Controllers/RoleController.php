<?php

namespace Modules\ManagementUser\Http\Controllers;

use App\Models\AksesMenu;
use App\Models\Menu;
use App\Models\RoleHasPermission;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use DataTables;
use Exception;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use ValidatesRequests;
    function __construct()
    {
         $this->middleware('permission:role-view|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
         $this->middleware('permission:role-view', ['only' => ['index']]);

    }

    public function data(){
        try{
            $data = Role::all();
            $canUpdate = Gate::allows('menu-edit');
            $canDelete = Gate::allows('menu-delete');
            return DataTables::of($data)
            ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                $btn = '';

                if ($canUpdate) {
                    $btn .= '<a class="btn-floating btn-small" href="role/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
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
        $name_page = "role";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('managementuser::role.index')->with($data);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {

        $name_page = "role";
        $menus = Menu::whereIn('position', ['parent','single'])->orderBy('order', 'asc')->get();
        $data = array(
            'page'          => $name_page,
            'menus'          => $menus,
            'UserRole'      => $this,
			'roleId'        => '',
			'role_name'     => '',
        );
        return view('managementuser::role.create')->with($data);

    }


    public function store(Request $request)
    {


            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);

            $permission = $request->permission;

            $role = Role::create(['name' => $request->input('name')]);

            $idMenu = array();
            foreach($permission as $a){
                $keys = explode('-', $a);
                $idMenu = $keys[0];

                // save menu
                if($keys[2] == 'view'){

                    $saveMenu = AksesMenu::create(
                        [
                            'menu_id' => $idMenu,
                            'role_id' => $role->id
                        ]
                    );

                    $getParent = Menu::where('id',$idMenu)->first();
                    $cekParent = AksesMenu::where('menu_id',$getParent->parent_id)->where('role_id', $role->id)->first();
                    if(!$cekParent){
                        $saveParent = AksesMenu::create([
                            'menu_id' => $getParent->parent_id,
                            'role_id' => $role->id
                        ]);
                    }
                }


                #save permission
                $permissionAction = "$keys[1]-$keys[2]";
                // dd($permissionAction);
                $cekpermission = Permission::where('name',$permissionAction)->first();
                if($cekpermission){
                    $saveHasPermission = new RoleHasPermission();
                    $saveHasPermission->permission_id = $cekpermission->id;
                    $saveHasPermission->role_id = $role->id;
                    $saveHasPermission->save();
                }

        }
        if ($cekpermission) {
            //redirect dengan pesan sukses
            return redirect()->route('role.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('role.index')->with(['error' => 'Data Gagal Disimpan!']);
        }

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")

            ->where("role_has_permissions.role_id",$id)

            ->get();

            $name_page = "role";
            $data = array(
                'page' => $name_page
            );



        return view('managementuser::role.show',compact('role','rolePermissions'))->with($data);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {
            
            $role = Role::find($id);
            $name_page = "role";
            $menus = Menu::whereIn('position', ['single','parent','none'])->orderBy('order', 'asc')->get();
      
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->leftJoin('permissions','permissions.id','role_has_permissions.permission_id')
            // ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->get();
            // dd($rolePermissions);
            // dd($rolePermissions);
            $dataname = array();
            foreach($rolePermissions as $datapermission){
                $dataname[] = $datapermission->name;
            }
           
            $data = array(
                'page'          => $name_page,
                'menus'          => $menus,
                'UserRole'      => $this,
                'roleId'        => '',
                'role_name'     => '',
                'data_permission' => json_encode($dataname),
            );

        return view('managementuser::role.edit',compact('role','rolePermissions'))->with($data);

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)
    {
       
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $permission = $request->permission;
        $idMenu = array();
        $deleteMenu =  AksesMenu::where('role_id', $id)->delete();
          //delete akses menu old
        $deletePermissionOld = RoleHasPermission::where('role_id', $id)->delete();
          // delete permision role old
        foreach($permission as $a){
            $keys = explode('-', $a);
          
            $nameMenu = str_replace(" ","",$keys[1]);
            $idMenu = $keys[0];
            // save menu
            if($keys[2] == 'view'){
                $saveMenu = AksesMenu::create(
                    [
                        'menu_id' => $idMenu,
                        'role_id' => $role->id
                    ]
                );

                $getParent = Menu::where('id',$idMenu)->first();
                $cekParent = AksesMenu::where('menu_id',$getParent->parent_id)->where('role_id', $role->id)->first();
                if(!$cekParent){
                    $saveParent = AksesMenu::create([
                        'menu_id' => $getParent->parent_id,
                        'role_id' => $role->id
                    ]);
                }
            }

            #save permission
            $permissionAction = "$nameMenu-$keys[2]";


            $cekpermission = Permission::where('name',$permissionAction)->first();

            if($cekpermission){
                $saveHasPermission = new RoleHasPermission();
                $saveHasPermission->permission_id = $cekpermission->id;
                $saveHasPermission->role_id = $role->id;
                $saveHasPermission->save();
            }

        }


        if ($role) {
            //redirect dengan pesan sukses
            return redirect()->route('role.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('role.index')->with(['error' => 'Data Gagal Diupdate!']);
        }


    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $delete = DB::table("roles")->where('id',$id)->delete();

        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->route('role.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('role.index')->with(['error' => 'Data Gagal Disimpan!']);
        }


    }


}
