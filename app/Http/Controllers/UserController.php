<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Model\Customer;
use App\User;

class UserController extends Controller
{

    function __construct()
    {
        $this->customer = new Customer;
        $this->user = new User;
    }

    public function index()
    {
        //
        $users = $this->user->paginate(20);
        return view('user.index',[
            'users' => $users
        ]);
    }
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with(['success' => 'User has been created']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        if($user){
            return view('user.edit', [
                'user' => $user,
            ]);            
        }else{
            return redirect()->route('user.create')->with(['danger' => 'User is not found, you can create a new User here']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->user->find($id);
        $user->name = $request->input('name'); 
        $user->email = $request->input('email'); 
        $user->password = Hash::make($request->password);

        if($user->save()){
            return redirect()->route('user.index')->with(['success' => 'User has updated']);
        }
    }
    public function inactive($id){
        return $this->change($id, 0, "In Active");
    }
    public function active($id){
        return $this->change($id, 1, "Active");
    }
    function change($id, $status, $des)
    {
        $user = $this->user->find($id);
        if($user){
            $user->status = $status; 
            if($user->save()){
                return redirect()->route('user.index')->with(['success' => '"'.$user->name.'" has been '.$des.'.']);
            }
        }else{
            return redirect()->route('user.index')->with(['success' => 'Sorry, Customer not found!']);
        }
    }

    public function destroy($id)
    {
        $user = $this->user->find($id);
        $u = $user;
        $user->delete();
        return redirect()->route('user.index')->with(['success' => 'User "'.$user->name.'" has deleted !']);
    }
}
