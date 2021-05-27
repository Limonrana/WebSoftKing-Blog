<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = User::with('role')->where('role_id', '!=', 4 || 0)->get();
        return response()->json($admin);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'fullName'              => 'required|max:25',
            'email'                 => 'required|max:25|email|unique:users',
            'password'              => 'required|min:6',
            'role_id'              => 'required',
        ]);
        $admin                      = new User();
        $admin->fullName            = $request->fullName;
        $admin->email               = $request->email;
        $admin->password            = Hash::make($request->password);
        $admin->role_id             = $request->role_id;
        $admin->save();
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
        $validation = $request->validate([
            'fullName'              => 'required|max:25',
            'email'                 => "required|max:25|email|unique:users,email,$request->id",
            'password'              => 'min:6',
            'role_id'               => 'required',
        ]);
        $admin                      =  User::find($id);
        $admin->fullName            = $request->fullName;
        $admin->email               = $request->email;
        $admin->password            = Hash::make($request->password);
        $admin->role_id             = $request->role_id;
        $admin->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = user::find($id);
        $admin->delete();
    }

    /**
     * Admin login system resource start.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminLogin(Request $request) {
        $validation = $request->validate([
            'email'                 => 'required|max:25|email',
            'password'              => 'required|min:6',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role_id == 4) {
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login details Role',
                ], 401);
            }
            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login details',
            ], 401);
        }
    }

    /**
     * Admin login check.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }

        $user = Auth::user();
        if ($user->role_id == 4) {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/dashboard');
        }
        if ($request->path() == '/') {
            return redirect('/dashboard');
        }

        return $this->checkPermission($user, $request);
        //return view('welcome');
    }

    /**
     * Admin Permission system Check.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkPermission($user, $request) {
        $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if (!$permission) return view('welcome');
        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if ($hasPermission) {
            return view('welcome');
        }
        else {
            return view('404');
        }
    }

    /**
     * Admin logout system resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }


    /**
     * Display a listing of the roles resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRole()
    {
        $roles = Role::where('isAdmin', '!=', 4)->where('isAdmin', '!=', 0)->get();
        return response()->json($roles);
    }

    /**
     * Store a newly created roles resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRole(Request $request)
    {
        $validation = $request->validate([
            'roleName'                 => 'required|max:25|unique:roles',
            'isAdmin'                  => 'required'
        ]);
        $role                          = new Role();
        $role->roleName                = $request->roleName;
        $role->isAdmin                 = $request->isAdmin;
        $role->save();
    }

    /**
     * Update the specified roles resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, $id)
    {
        $validation = $request->validate([
            'roleName'                 => "required|max:25|unique:roles,roleName,$request->id",
            'isAdmin'                  => 'required'
        ]);
        $role                          =  Role::find($id);
        $role->roleName                = $request->roleName;
        $role->isAdmin                 = $request->isAdmin;
        $role->save();
    }

    /**
     * Remove the specified roles resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRole($id)
    {
        $role = Role::find($id);
        $role->delete();
    }

    /**
     * Store a newly created permission resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function permissionAssign(Request $request) {
        $validation = $request->validate([
            'permission'          => 'required',
            'id'                  => 'required'
        ]);
        $permission               =  Role::find($request->id);
        $permission->permission   = $request->permission;
        $permission->save();
    }
}
