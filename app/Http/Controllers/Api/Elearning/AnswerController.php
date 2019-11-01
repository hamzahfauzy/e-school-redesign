<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\QuestionAnswer as Answer;
use Validator;

class AnswerController extends Controller
{
    public $success = 200;

    public function index($question_id){
        $answers = Answer::where('question_id',$question_id)->get();
        return response()->json($answers,$this->success);
    }

    public function single($id){
        $answer = Answer::find($id);
        return response()->json($answer,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'question_id'  =>  'required',
            'title'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('question_id','title');
        $answer = Answer::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'question_id'  =>  'required',
            'title'      =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('question_id','title');
        $answer = Answer::find($request->id);
        $answer->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $answer = Answer::find($request->id);
        if($answer->teacher_id == $request->teacher_id)
        {
	        $answer->delete();
	        return response()->json(['success'=>1],$this->success);
        }
        return response()->json(['success'=>0],$this->success);
    }
}
