<?php

namespace Modules\ManagementUser\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;
use Exception;
use DataTables;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;
    public function data()
    {
        try {
            $data = Permission::all();
            return DataTables::of($data)
                // ->addColumn('roles', function ($data) {
                //     //dd($data);
                //     if (!empty($data->getRoleNames())) {
                //         return json_decode($data->getRoleNames());
                //     }
                // })
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
        $name_page = "permission";
        $data = array(
            'page' => $name_page
        );
        return view('managementuser::permission.index')->with($data);
    }



    public function create()
    {

        // $user = Auth::user();
        // $roles = Role::all();
        // $userRole = $user->roles->pluck('id');
        // $menu = akses_menu::with('menu')->where('role_id', $userRole)->get();
        $name_page = "permission";
        $data = array(
            'page' => $name_page
        );
        return view('managementuser::permission.create')->with($data);
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $action = ['view','create','edit','delete'];

        foreach($action as $act => $value){
            $save = new Permission();
            $save->name = $request->name.'-'.$value;
            $save->save();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('permission.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('permission.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    // public function show($id)
    // {
    //     $user = User::find($id);
    //     return view('users.show',compact('user'));
    // }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {
        $permission = Permission::find($id);
        $name = $permission->name;
        $key = explode('-', $name);
        $keyword = $key[0];

        // $roles = Role::all();
        // $userRole = $user->roles->first();
        // $user = Auth::user();
        // $userRole = $user->roles->pluck('id');
        // $menu = akses_menu::with('menu')->where('role_id', $userRole)->get();
        $name_page = "permission";
        $data = array(
            'page' => $name_page,
            'keyword' => $keyword,

        );
        return view('managementuser::permission.edit', compact('permission'))->with($data);
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
        try{
            $this->validate($request, [
                'name' => 'required',
            ]);


            $permission = Permission::find($id);
            $name = $permission->name;
            $key = explode('-', $name);
            $keyword = $key[0];



            $getDataPermission = Permission::where('name', 'like', '%' . $keyword . '%')->pluck('id');

            $action = ['view','create','edit','delete'];

            foreach($getDataPermission as $ids){
                $permission = Permission::find($ids);
                $name = $permission->name;
                $key = explode('-', $name);
                $keyword = $key[0];
                $keyword2 = $key[1];

                $update = Permission::where('id',$ids)
                ->update([
                    'name' => $request->name.'-'.$keyword2
                ]);

            }

            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('permission.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('permission.index')->with(['error' => 'Data Gagal Diubah!']);
            }
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



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        try{
            $permission = Permission::find($id);
            $name = $permission->name;
            $key = explode('-', $name);
            $keyword = $key[0];


            $getDataPermission = Permission::where('name', 'like', '%' . $keyword . '%')->pluck('id');
            foreach( $getDataPermission as $ids){
                Permission::find($ids)->delete();
            }

            return redirect()->route('permission.index')
                ->with('success', 'Data berhasil dihapus');

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
}
