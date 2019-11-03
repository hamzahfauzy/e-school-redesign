<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Model\InformationSystem\Classroom;
use App\Model\InformationSystem\Major;
use App\User;

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

    public function studentCreate($id)
    {   
        $classroom = auth()->user()->customer->school->classrooms()->find($id);
        $students = auth()->user()->customer->school->students();
        return view('customer-section.classroom.student-create', ["classroom"=>$classroom, "students"=>$students]);
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
            'user_id' => $request->teacher,
        ]);

        return redirect()->route('sistem-informasi.classrooms.index')->with(['success' => 'Kelas berhasil ditambahkan']);
    }

    public function storeStudent(Request $request)
    {
        $this->validate($request,[
            'student' => 'required',
            'classroom_id' => 'required',
        ]);

        $user = User::find($request->student);
        $classroom = auth()->user()->customer->school->classrooms()->find($request->classroom_id)->students()->attach($user);

        return redirect()->route('sistem-informasi.classrooms.show',$request->classroom_id)->with(['success' => 'Siswa berhasil ditambahkan']);
    }

    public function show($id)
    {
        $classroom = auth()->user()->customer->school->classrooms()->find($id);
        $students = $classroom->students()->paginate(10);
        return view('customer-section.classroom.show',[
            'classroom' => $classroom,
            'students' => $students
        ]);
    }

    public function edit($id)
    {
        $majors = auth()->user()->customer->school->majors;
        $teachers = auth()->user()->customer->school->teachers();
        $classroom = auth()->user()->customer->school->classrooms()->find($id);
        if($classroom){
            return view('customer-section.classroom.edit', [
                'classroom' => $classroom,
                "majors"=>$majors, 
                "teachers"=>$teachers
            ]);            
        }else{
            return redirect()->route('sistem-informasi.classrooms.create')->with(['danger' => 'User is not found, you can create a new User here']);
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
            return redirect()->route('sistem-informasi.classrooms.index')->with(['success' => 'Kelas telah di update']);
        }
    }

    public function destroy($id)
    {
        $classroom = auth()->user()->customer->school->classrooms()->find($id);
        $classroom->delete();
        return redirect()->route('sistem-informasi.classrooms.index')->with(['success' => 'Kelas berhasil di hapus']);
    }

    public function destroyStudent($id, $user_id)
    {
        $classroom = auth()->user()->customer->school->classrooms()->find($id);
        $classroom->students()->detach($user_id);
        return redirect()->route('sistem-informasi.classrooms.show',$id)->with(['success' => 'Siswa berhasil di hapus dari kelas!']);
    }
}
