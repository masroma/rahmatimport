<?php

namespace Modules\ManagementUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use DataTables;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use ValidatesRequests;
    public function data(){
        try{
            $data = Role::all();

            return DataTables::of($data)
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
        // $user = Auth::user();
        // $userRole = $user->roles->pluck('id');
        // $menu = akses_menu::with('menu')->where('role_id', $userRole)->get();
        $name_page = "role";
        $data = array(
            'page' => $name_page
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

        $permission = Permission::get()->chunk(4);
        // $user = Auth::user();
        // $userRole = $user->roles->pluck('id');
        // $menu = akses_menu::with('menu')->where('role_id', $userRole)->get();
        $name_page = "role";
        $data = array(
            'page' => $name_page
        );
        return view('managementuser::role.create',compact('permission'))->with($data);

    }


    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required|unique:roles,name',
            'permission' => 'required',

        ]);

        $role = Role::create(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permission'));

        if ($role) {
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
        $permission = Permission::get()->chunk(4);

        // $user = Auth::user();
        // $userRole = $user->roles->pluck('id');
        // $menu = akses_menu::with('menu')->where('role_id', $userRole)->get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
            $name_page = "role";
            $data = array(
                'page' => $name_page
            );
        return view('managemenetuser::role.edit',compact('role','permission','rolePermissions'))->with($data);

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

        $role->syncPermissions($request->input('permission'));

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
