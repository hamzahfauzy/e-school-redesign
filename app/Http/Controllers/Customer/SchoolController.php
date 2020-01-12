<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\SchoolProfile as School;
use File;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!auth()->user()->customer->school)
        {
            $school = School::create([
                'customer_id' => auth()->user()->customer->id
            ]);

            $path = public_path().'/uploads/schools/' . $school->id;
            if(file_exists($path)) mkdir($path);
        }
        return view('customer-section.school.index',[
            'school' => auth()->user()->customer->school
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $this->validate($request, [
            'school_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'headmaster_name' => 'required',
            'headmaster_employee_id' => 'required',
        ]);

        auth()->user()->customer->school()->update([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'headmaster_name' => $request->headmaster_name,
            'headmaster_employee_id' => $request->headmaster_employee_id,
            'dapodik_token' => $request->dapodik_token,
        ]);
        
        return redirect()->route('sistem-informasi.schools.index')->with(['success' => 'Data Sekolah berhasil di update']);
    }

    public function upload(Request $request)
    {
        $this->validate($request,[
            'picture' => 'required'
        ]);

        $destinationPath = public_path()."/uploads/schools/".auth()->user()->customer->school->id;
        $file = $request->file('picture');
        $file->move($destinationPath, $file->getClientOriginalName());
        auth()->user()->customer->school()->update([
            'picture' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('sistem-informasi.schools.index')->with(['upload_success' => 'Foto Sekolah berhasil di update']);
    }

}
