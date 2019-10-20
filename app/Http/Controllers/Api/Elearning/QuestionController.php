<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\Question;
use Validator;

class QuestionController extends Controller
{
    public $success = 200;

    public function index($teacher_id){
        $questions = Question::where('teacher_id',$teacher_id)->get();
        return response()->json($questions,$this->success);
    }

    public function single($id){
        $question = Question::find($id);
        return response()->json($question,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'title'      	=>  'required',
            'description'   =>  'required',
            'question_type'   =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('teacher_id','study_id','title','description','question_type');
        $question = Question::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'id'            =>  'required',
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'title'      	=>  'required',
            'description'   =>  'required',
            'question_type' =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('teacher_id','id','study_id','title','description','question_type');
        $question = Question::find($request->id);
        $question->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function setCorrectAnswer(Request $request){
        $validator = Validator::make($request->all(),[
            'key_answer_id'      =>  'required',
            'id'             =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('key_answer_id','id');
        $question = Question::find($request->id);
        $question->update($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $question = Question::find($request->id);
        if($question->teacher_id == $request->teacher_id)
        {
	        $question->delete();
	        return response()->json(['success'=>1],$this->success);
        }
	    return response()->json(['success'=>0],$this->success);
    }
}
