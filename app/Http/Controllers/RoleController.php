<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Role;

class RoleController extends Controller
{

    function __construct()
    {
        $this->role = new Role;
    }

    public function index()
    {
        //
        $roles = $this->role->paginate(20);
        return view('role.index',[
            'roles' => $roles
        ]);
    }
    public function create()
    {
        return view('role.create');
    }

    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all(); 
        $this->role->create($input);

        return redirect()->route('role.index')->with(['success' => 'Create role success']);;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = $this->role->find($id);
        if($role){
            return view('role.edit', [
                'role' => $role,
            ]);            
        }else{
            return redirect()->route('role.create')->with(['danger' => 'Role is not found, you can create a new Role here']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
        ]);

        $role = $this->role->find($id);
        $role->name = $request->input('name'); 
        $role->description = $request->input('description'); 
        $role->slug = $request->input('slug'); 
        $role->save();
        return redirect()->route('role.index')->with(['success' => 'Data has updated !']);
    }

    public function destroy($id)
    {
        $role = $this->role->find($id);
        $r = $role;
        $role->delete();
        return redirect()->route('role.index')->with(['success' => 'Role "'.$r->name.'" has deleted !']);
    }
}
