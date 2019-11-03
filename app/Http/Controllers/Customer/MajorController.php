<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Major;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-section.major.index',[
            'majors' => auth()->user()->customer->school->majors()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('customer-section.major.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        auth()->user()->customer->school->majors()->create([
            'name' => $request->name
        ]);

        return redirect()->route('sistem-informasi.majors.index')->with(['success' => 'Tambah jurusan berhasil!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $major = auth()->user()->customer->school->majors()->find($id);
        return view('customer-section.major.edit',[
            'major' => $major
        ]);
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
        $this->validate($request,[
            'name' => 'required'
        ]);

        auth()->user()->customer->school->majors()->find($id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('sistem-informasi.majors.index')->with(['success' => 'Tambah jurusan berhasil!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->customer->school->majors()->find($id)->delete();

        return redirect()->route('sistem-informasi.majors.index')->with(['success' => 'Hapus jurusan berhasil!']);
    }
}
