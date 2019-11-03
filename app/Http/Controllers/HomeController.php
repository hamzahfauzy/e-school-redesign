<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        if(auth()->user()->isRole('admin_sistem_informasi'))
        {
            auth()->user()->customer()->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);


        if($request->password)
        {
            auth()->user()->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->route('profile')->with(['success' => 'Data Anda berhasil di update']);
    }

    public function profileUpload(Request $request)
    {
        $this->validate($request,[
            'picture' => 'required'
        ]);

        if(auth()->user()->isRole('admin_sistem_informasi'))
        {
            $destinationPath = public_path()."/uploads/schools/".auth()->user()->customer->school->id;
            $file = $request->file('picture');
            $file->move($destinationPath, $file->getClientOriginalName());
            auth()->user()->customer()->update([
                'picture' => $file->getClientOriginalName(),
            ]);
        }
        else
        {
            $destinationPath = public_path()."/uploads/schools/".auth()->user()->school[0]->id."/".auth()->user()->id;
            if(!file_exists($destinationPath))
                mkdir($destinationPath);
            $file = $request->file('picture');
            $file->move($destinationPath, $file->getClientOriginalName());
            auth()->user()->update([
                'picture' => $file->getClientOriginalName(),
            ]);
        }
        

        return redirect()->back();
    }
}
