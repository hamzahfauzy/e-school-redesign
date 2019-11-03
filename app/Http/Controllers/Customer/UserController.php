<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Role;
use App\User;

class UserController extends Controller
{
    function __construct()
    {
        $this->user = new User;
        $this->role = new Role;
    }

    public function index()
    {
        $users = auth()->user()->customer->school->users()->paginate(10);
        return view('customer-section.user.index',[
            'users' => $users
        ]);
    }

    public function students()
    {
        $users = auth()->user()->customer->school->students();
        return view('customer-section.user.students',[
            'users' => $users
        ]);
    }

    public function teachers()
    {
        $users = auth()->user()->customer->school->teachers();
        return view('customer-section.user.teachers',[
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('customer-section.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if(auth()->user()->customer->school->users()->attach($user))
            return 1;

        return redirect()->route('sistem-informasi.users.index')->with(['success' => 'Pengguna berhasil di tambah.']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = auth()->user()->customer->school->users()->find($id);
        if($user){
            return view('customer-section.user.edit', [
                'user' => $user,
            ]);            
        }else{
            return redirect()->route('sistem-informasi.users.create')->with(['danger' => 'User is not found, you can create a new User here']);
        }
    }

    public function addRole($id)
    {
        $user = auth()->user()->customer->school->users()->find($id);
        if($user){
            return view('customer-section.user.add-role', [
                'user' => $user,
                'roles' => $this->role->where('slug','!=','admin')->where('slug','!=','admin_sistem_informasi')->get(),
            ]);            
        }else{
            return redirect()->route('sistem-informasi.users.create')->with(['danger' => 'User is not found, you can create a new User here']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required:unique:users,email,'.$id.',id,email,'.$request->email,
            // 'password' => 'required|string|min:8',
        ]);

        $user = auth()->user()->customer->school->users()->find($id);
        $user->name = $request->input('name'); 
        $user->email = $request->input('email'); 
        if(!empty($request->password))
            $user->password = Hash::make($request->password);

        if($user->save()){
            return redirect()->route('sistem-informasi.users.index')->with(['success' => 'Pengguna berhasil di update']);
        }
    }

    public function saveRole(Request $request, $id)
    {
        $this->validate($request,[
            'role_id' => 'required',
        ]);

        $user = auth()->user()->customer->school->users()->find($id);
        $role = $this->role->find($request->role_id);
        $user->roles()->attach($role);
        return redirect()->route('sistem-informasi.users.index')->with(['success' => 'Tambah peran pengguna berhasil']);
    }

    public function destroy($id)
    {
        $user = auth()->user()->customer->school->users()->find($id);
        $u = $user;
        $user->delete();
        return redirect()->route('sistem-informasi.users.index')->with(['success' => 'Pengguna "'.$user->name.'" telah di hapus !']);
    }

    public function destroyRole(Request $request, $id)
    {
        $user = auth()->user()->customer->school->users()->find($id);
        $role = Role::find($request->role_id);
        $user->roles()->detach($role);
        return redirect()->route('sistem-informasi.users.index')->with(['success' => 'Peran '.$role->name.' pada pengguna "'.$user->name.'" telah di hapus !']);
    }
}
