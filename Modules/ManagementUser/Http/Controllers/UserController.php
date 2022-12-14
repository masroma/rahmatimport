<?php

namespace Modules\ManagementUser\Http\Controllers;

use App\Models\AksesMenu;
use App\Models\User;
use Exception;
use Hash;
use DataTables;
use Auth;
use Gate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */



    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:user-create|user-edit|user-delete|user-view', ['only' => ['index','store']]);
         $this->middleware('permission:user-view', ['only' => ['index']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }


    public function data()
    {
        try {

            $canUpdate = Gate::allows('user-edit');
            $canDelete = Gate::allows('user-delete');
            $data = User::all();
            return DataTables::of($data)
                ->addColumn('roles', function ($data) {
                    if (!empty($data->getRoleNames())) {
                        return json_decode($data->getRoleNames());
                    }
                })
                ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                    $btn = '';

                    if ($canUpdate) {
                        $btn .= '<a class="btn-floating btn-small" href="user/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
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
        $canCreate = Gate::allows('user-create');
        $name_page = "user";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate


        );
        return view('managementuser::user.index')->with($data);
    }



    public function create()
    {

        $user = Auth::user();
        $roles = Role::all();
        $userRole = $user->roles->pluck('id');
        // $roles = Role::all();
        // $userRole = $user->roles->pluck('id');
        // $menu = akses_menu::with('menu')->where('role_id', $userRole)->get();
        $name_page = "user";
        $data = array(
            'page' => $name_page,
            'roles' => $roles,
            'userRole' => $userRole
        );
        return view('managementuser::user.create')->with($data);
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            // 'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        if ($user) {
            //redirect dengan pesan sukses
            return redirect()->route('user.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('user.index')->with(['error' => 'Data Gagal Disimpan!']);
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
        $user = User::findORFail($id);

        $roles = Role::all();

        $userRole = $user->roles->first();

        $name_page = "user";
        $data = array(
            'page' => $name_page,
            'roles' => $roles,
            'userRole' => $userRole
        );
        return view('managementuser::user.edit', compact('user'))->with($data);
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
            'email' => 'required|email|unique:users,email,' . $id,
            // 'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        if ($user) {
            //redirect dengan pesan sukses
            return redirect()->route('user.index')->with(['success' => 'Data Berhasil Diubah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('user.index')->with(['error' => 'Data Gagal Diubah!']);
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

        User::find($id)->delete();
        return redirect()->route('user.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function editprofile(){
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $name_page = "profile user";
        $data = array(
            'page' => $name_page
        );
        return view('managementuser::user.editprofile',compact('user'))->with($data);
    }

    public function proseseditprofile(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $messages = [
            'required' => 'Kolom Wajib diisi!',
            'unique' => 'Kode sudah digunakan',
            'email' => 'Kolom harus format email'
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,

        ], $messages);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();

        if($request->password != null){
            $user->password = bcrypt($request->password);
            $user->save();
        }


        if ($user) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()>with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
