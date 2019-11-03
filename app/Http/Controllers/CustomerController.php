<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Model\{Customer,Role};
use App\User;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->customer = new Customer;
        $this->user = new User;
    }

    public function index()
    {
        //
        $customers = $this->customer->paginate(20);
        return view('customer.index',[
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return view('customer.create');
    }

    public function new()
    {
        $users = $this->user->orderBy('name', 'ASC')->get();
        return view('customer.new', ['users'=>$users]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'expired_at' => 'required',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customer = $this->customer->create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'status' => 0,
            'expired_at' => $request->expired_at
        ]);

        $role = Role::where('slug','admin_sistem_informasi')->first();
        if(!empty($role))
            $user->roles()->attach($role);

        return redirect()->route('customer.index')->with(['success' => 'Customer has been created']);
    }
    public function newstore(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required',
            'phone_number' => 'required',
            'expired_at' => 'required',
        ]);

        $user = $this->user->find($request->user_id);
        $customer = $this->customer->create([
            'user_id' => $request->user_id,
            'name' => $user->name,
            'phone_number' => $request->phone_number,
            'email' => $user->email,
            'status' => 0,
            'expired_at' => $request->expired_at
        ]);

        $role = Role::where('name','Customer')->first();
        if(!empty($role))
            $user->roles()->attach($role);

        return redirect()->route('customer.index')->with(['success' => 'Customer has been created']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $customer = $this->customer->find($id);
        if($customer){
            return view('customer.edit', [
                'customer' => $customer,
            ]);            
        }else{
            return redirect()->route('customer.create')->with(['danger' => 'Customer is not found, you can create a new Customer here']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'expired_at' => 'required',
            // 'password' => 'required|string|min:8',
        ]);

        $customer = $this->customer->find($id);
        $customer->name = $request->input('name'); 
        $customer->email = $request->input('email'); 
        $customer->phone_number = $request->input('phone_number'); 
        $customer->expired_at = $request->input('expired_at'); 
        if($customer->save()){
            $user = $this->user->find($customer->user_id);
            $user->name = $request->input('name'); 
            $user->email = $request->input('email'); 
            if(!empty($request->password))
                $user->password = Hash::make($request->input('password')); 

            if(empty($user->roles) || count($user->roles) == 0)
            {
                $role = Role::where('name','Customer')->first();
                if(!empty($role))
                    $user->roles()->attach($role);
            }

            $user->save();
        }

        return redirect()->route('customer.index')->with(['success' => 'Data has updated !']);
    }
    public function disable($id){
        return $this->change($id, 0, "Disabled");
    }
    public function active($id){
        return $this->change($id, 1, "Activated");
    }
    public function expired($id){
        return $this->change($id, 2, "Expired");
    }
    function change($id, $status, $des)
    {
        $customer = $this->customer->find($id);
        if($customer){
            $customer->status = $status; 
            if($customer->save()){
                return redirect()->route('customer.index')->with(['success' => '"'.$customer->name.'" has been '.$des.'.']);
            }
        }else{
            return redirect()->route('customer.index')->with(['success' => 'Sorry, Customer not found!']);
        }
    }

    public function destroy($id)
    {
        $customer = $this->customer->where('user_id', $id)->first();
        if($customer->delete()){
            return redirect()->route('customer.index')->with(['success' => 'Data has deleted !']);
        }
    }
}
