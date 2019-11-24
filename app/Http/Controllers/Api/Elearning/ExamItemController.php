<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Elearning\{Exam,ExamItem,ExamAnswer,Question};

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
        $answers = $request->answers;
        $exam = Exam::find($request->exam_id);
        foreach($answers as $key => $value)
        {

            $item = $exam->questions()->where('question_id',$key)->first();
            $answer = ExamAnswer::where('exam_item_id',$item->pivot->id)
                                    ->where('student_id',$request->student_id)
                                    ->first();

            $question = Question::find($key);

            if(empty($answer))
            {
                $create = [
                    'exam_item_id' => $item->pivot->id,
                    'student_id'   => $request->student_id,
                ];
                if($question->type == 'Essay')
                    $create['question_answer_text'] = $value;
                else
                {
                    $create['question_answer_id'] = $value;
                    $create['score'] = $value == $question->key_answer_id ? 1 : 0;
                }
                ExamAnswer::create($create);
                continue;
            }
            $update = [];
            if($question->type == 'Essay')
                $update['question_answer_text'] = $value;
            else
            {
                $update['question_answer_id'] = $value;
                $update['score'] = $value == $question->key_answer_id ? 1 : 0;
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
