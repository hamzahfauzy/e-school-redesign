<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Model\InformationSystem\Classroom;
use App\Model\InformationSystem\Major;

class ClassroomController extends Controller
{

    function __construct()
    {
        $this->classroom = new Classroom;
    }

    public function index()
    {
        //
        $classrooms = auth()->user()->customer->school->classrooms()->paginate(20);
        return view('customer-section.classroom.index',[
            'classrooms' => $classrooms
        ]);
    }
    public function create()
    {   
        $majors = auth()->user()->customer->school->majors;
        $teachers = auth()->user()->customer->school->teachers();
        return view('customer-section.classroom.create', ["majors"=>$majors, "teachers"=>$teachers]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'major' => 'required',
            'teacher' => 'required'
        ]);

        $classroom = $this->classroom->create([
            'school_id'=>auth()->user()->customer->school->id,
            'name' => $request->name,
            'major_id' => $request->major,
            'employee_id' => $request->teacher,
        ]);

        return redirect()->route('sistem-informasi.classrooms.index')->with(['success' => 'Kelas berhasil ditambahkan']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = auth()->user()->customer->school->classrooms()->find($id);
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
