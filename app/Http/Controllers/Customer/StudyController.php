<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Study;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('customer-section.study.index',[
            'studies' => auth()->user()->customer->school->studies()->paginate(10)
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
        return view('customer-section.study.create');
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

        auth()->user()->customer->school->studies()->create([
            'name' => $request->name
        ]);

        return redirect()->route('sistem-informasi.studies.index')->with(['success' => 'Tambah mata pelajaran berhasil!']);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importStudy' => 'required'
        ]);

        $path = $request->file('importStudy')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        unset($data[0]);
        // $csv_data = array_slice($data, 0, 2);
        foreach($data as $row)
        {
            $name = ucwords(strtolower($row[1]));
            $existing = auth()->user()->customer->school->studies()->where('name',$name)->first();
            if(!$existing)
                auth()->user()->customer->school->studies()->create([
                    'name' => $name
                ]);
        }

        return redirect()->route('sistem-informasi.studies.index')->with(['success' => 'Import mata pelajaran berhasil!']);
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
        $study = auth()->user()->customer->school->studies()->find($id);
        return view('customer-section.study.edit',[
            'study' => $study
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

        auth()->user()->customer->school->studies()->find($id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('sistem-informasi.studies.index')->with(['success' => 'Tambah mata pelajaran berhasil!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->customer->school->studies()->find($id)->delete();

        return redirect()->route('sistem-informasi.studies.index')->with(['success' => 'Hapus mata pelajaran berhasil!']);
    }
}
