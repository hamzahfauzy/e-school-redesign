<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Elearning\{Exam,ExamItem,ExamAnswer};

class ExamItemController extends Controller
{
    public $success = 200;

    public function index($exam_id){
        $exams = ExamItem::where('exam_id',$exam_id)->get();
        foreach ($exams as $exam) {
        	$exam->exam;
        	$exam->question;
        }
        return response()->json($exams,$this->success);
    }

    public function answer(Request $request){
        foreach($request->all() as $req)
        {
            $answer = ExamAnswer::where('exam_item_id',$req['exam_item_id'])
                                    ->where('student_id',$req['student_id'])
                                    ->first();

            if(empty($answer))
            {
                $create = [
                    'exam_item_id' => $req['exam_item_id'],
                    'student_id'   => $req['student_id'],
                ];
                if($req['question_type'] == 'Essay')
                    $create['question_answer_text'] = $req['answer'];
                else
                {
                    $examItem = ExamItem::find($req['exam_item_id']);
                    $question = $examItem->question;
                    $create['question_answer_id'] = $req['answer'];
                    $create['score'] = $req['answer'] == $question->key_answer_id ? 1 : 0;
                }
                ExamAnswer::create($create);
                continue;
            }
            $update = [];
            if($req['question_type'] == 'Essay')
                $update['question_answer_text'] = $req['answer'];
            else
            {
                $examItem = ExamItem::find($req['exam_item_id']);
                $question = $examItem->question;
                $update['question_answer_id'] = $req['answer'];
                $update['score'] = $req['answer'] == $question->key_answer_id ? 1 : 0;
            }
            $answer->update($update);
        }
        return response()->json(['success'=>1],$this->success);
    }

    public function single($id){
        $exam = ExamItem::find($id);
        return response()->json($exam,$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'exam_id'		=>  'required',
            'question_id'	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('exam_id','question_id');
        $exam = ExamItem::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function delete(Request $request){
        $exam = ExamItem::find($request->id);
	    $exam->delete();
	    return response()->json(['success'=>0],$this->success);
    }
}
