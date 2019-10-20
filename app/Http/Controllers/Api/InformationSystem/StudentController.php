<?php

namespace App\Http\Controllers\Api\InformationSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\InformationSystem\Student;
use Validator;

class StudentController extends Controller
{
    public $success = 200;

    public function index(){
        $students = Student::get();
        return response()->json($students,$this->success);
    }

    public function single($id){
        $student = Student::find($id);
        $student->class_room;
        return response()->json($student,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'NISN'      =>  'required',
            'name'      =>  'required',
            'address'   =>  'required',
            'gender'    =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('NISN','name','address','gender');
        $student = Student::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'NISN'      =>  'required',
            'name'      =>  'required',
            'address'      =>  'required',
            'gender'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('NISN','name','address','gender');
        $student = Student::find($request->id);
        $student->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $student = Student::find($request->id);
        $student->delete();
        return response()->json(['success'=>1],$this->success);
    }
}
