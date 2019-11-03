<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Role;

class RoleController extends Controller
{
    //
    function index()
    {
    	return view('customer-section.role.index',[
    		'roles' => Role::where('slug','!=','admin')->where('slug','!=','admin_sistem_informasi')->paginate(10)
    	]);
    }
}
