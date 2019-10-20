<?php

namespace App\Http\Controllers\Api\InformationSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\InformationSystem\Employee;
use Validator;

class EmployeeController extends Controller
{
    public $success = 200;

    public function index(){
        $employees = Employee::get();
        foreach($employees as $employee){
            $employee->studies;
            $employee->class_rooms;
        }
        return response()->json($employees,$this->success);
    }

    public function single($id){
        $employee = Employee::find($id);
        $employee->studies;
        $employee->class_rooms;
        return response()->json($employee,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'NIP'               =>  'required',
            'name'              =>  'required',
            'address'           =>  'required',
            'gender'            =>  'required',
            'phone_number'      =>  'required',
            'employee_status'   =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('NIP','name','address','gender','phone_number','employee_status');
        $employee = Employee::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'NIP'               =>  'required',
            'name'              =>  'required',
            'address'           =>  'required',
            'gender'            =>  'required',
            'phone_number'      =>  'required',
            'employee_status'   =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('NIP','name','address','gender','phone_number','employee_status');
        $employee = Employee::find($request->id);
        $employee->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $employee = Employee::find($request->id);
        $employee->delete();
        return response()->json(['success'=>1],$this->success);
    }

    public function addStudy(Request $request){
        $employee = Employee::find($request->id);
        $employee->studies()->attach($request->study_id,['classroom_id'=>$request->classroom_id]);
        return response()->json(['success'=>1],$this->success);
    }

    public function deleteStudy(Request $request){
        $employee = Employee::find($request->id);
        $employee->studies()->wherePivot('classroom_id',$request->classroom_id)->detach($request->study_id);
        return response()->json(['success'=>1],$this->success);
    }
}
