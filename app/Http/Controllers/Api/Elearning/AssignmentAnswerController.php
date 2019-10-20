<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\AssignmentAnswer;
use Validator;

class AssignmentAnswerController extends Controller
{
    public $success = 200;

    function get($student_id)
    {
    	$answered = AssignmentAnswer::where('student_id',$student_id)->get();
    	return response()->json($answered,$this->success);
    }

    function create(Request $request)
    {
    	$validator = Validator::make($request->all(),[
            'student_id'    =>  'required',
            'assignment_id' =>  'required',
            'file_url'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('student_id','assignment_id','file_url');
        $announcement = AssignmentAnswer::create($input);
        return response()->json(['success'=>1],$this->success);
    }
}
