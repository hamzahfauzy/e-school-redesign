<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\{Menu,Role};

class MenuController extends Controller
{

    function __construct()
    {
        $this->menu = new Menu;
        $this->role = new Role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('menu.index',[
            'menus' => $this->menu->paginate(10)
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
        return view('menu.create',[
            'roles' => $this->role->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'role_id' => 'required',
            'name' => 'required',
            'route' => 'required',
            'ordered_number' => 'required',
        ]);

        $input = $request->all(); 
        $this->menu->create($input);

        return redirect()->route('menu.index')->with(['success' => 'Create menu success']);;
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
    public function edit(Menu $id)
    {
        return view('menu.edit',[
            'roles' => $this->role->get(),
            'menu' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $id)
    {
        //
        $this->validate($request,[
            'role_id' => 'required',
            'name' => 'required',
            'route' => 'required',
            'ordered_number' => 'required',
        ]);

        $input = $request->all(); 
        $id->update($input);

        return redirect()->route('menu.index')->with(['success' => 'Update menu success']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $id)
    {
        $id->delete();
        return redirect()->route('menu.index')->with(['success' => 'Delete menu success']);;

    }
}
