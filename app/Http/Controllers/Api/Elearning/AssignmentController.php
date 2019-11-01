<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\Assignment;
use Validator;

class AssignmentController extends Controller
{
    public $success = 200;

    public function index($teacher_id){
        $assignments = Assignment::where('teacher_id',$teacher_id)->get();
        return response()->json($assignments,$this->success);
    }

    public function single($id){
        $assignment = Assignment::find($id);
        return response()->json($assignment,$this->success);
    }

    function get(Assignment $assignment)
    {
        return response()->json($assignment->answers,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'classroom_id'  =>  'required',
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'file_url'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('classroom_id','teacher_id','study_id','file_url');
        $assignment = Assignment::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'classroom_id'      =>  'required',
            'teacher_id'      =>  'required',
            'study_id'      =>  'required',
            'file_url'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('classroom_id','teacher_id','study_id','file_url');
        $assignment = Assignment::find($request->id);
        $assignment->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $assignment = Assignment::find($request->id);
        if($assignment->teacher_id == $request->teacher_id)
        {
	        $assignment->delete();
	        return response()->json(['success'=>1],$this->success);
        }
        return response()->json(['success'=>0],$this->success);
    }
}
