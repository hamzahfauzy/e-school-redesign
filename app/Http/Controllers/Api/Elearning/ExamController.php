<?php

namespace App\Http\Controllers\Api\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Elearning\{Exam,ExamItem,ExamAnswer,ExamStudent};

class ExamController extends Controller
{
    public $success = 200;

    public function index($teacher_id){
        $exams = Exam::where('teacher_id',$teacher_id)->get();
        return response()->json($exams,$this->success);
    }

    public function single($id){
        $exam = Exam::find($id);
        $exam->items;
        foreach($exam->students as $student)
        {
            $totalScore = 0;
            $examItems = ExamItem::where('exam_id',$student->exam_id)->get();
            foreach($examItems as $item)
            {
                $answer = ExamAnswer::where('exam_item_id',$item->id)->where('student_id',$student->student_id)->first();
                $totalScore += $answer->score;
            }

            $totalScore = number_format(($totalScore / count($examItems))*10,2);
            $student->totalScore = $totalScore;
        }
        return response()->json($exam,$this->success);
    }

    public function singleWithStudents($id){
        $exam = Exam::find($id);
        return response()->json($exam,$this->success);
    }

    public function answers($id,$student_id){
        $response = [];
        $exam = Exam::find($id);
        foreach($exam->items as $item)
        {
            $answer = ExamAnswer::where('exam_item_id',$item->id)->where('student_id',$student_id)->first();
            if(empty($answer))
                continue;
            $response[] = $item->question->question_type == 'Essay' ? $answer->question_answer_text : $answer->question_answer_id;
        }
        return response()->json($response,$this->success);
    }

    public function getStatus($id,$student_id){
        $exam = ExamStudent::where('exam_id',$id)->where('student_id',$student_id)->first();
        return response()->json($exam,$this->success);
    }

    public function setStatus(Request $request){
        $exam = ExamStudent::create([
            'exam_id' => $request->exam_id,
            'student_id' => $request->student_id,
            'status' => 1,
        ]);
        return response()->json(['success'=>1],$this->success);
    }

    public function getStudentAnswer(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'item_ids'   =>  'required',
            'student_id' =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $response = [];
        foreach($request->item_ids as $item_id)
        {
            $examItem = ExamItem::find($item_id);
            $answer = ExamAnswer::where('exam_item_id',$item_id)->where('student_id',$request->student_id)->first();
            $answer->question = $examItem->question;
            if($examItem->question->question_type == 'Pilihan Berganda')
                $answer->answer;
            $response[] = $answer;
        }
        return response()->json($response,$this->success);
    }

    public function getStudentTotalScore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'exam_id'   =>  'required',
            'student_id' =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }

        $totalScore = 0;
        $examItems = ExamItem::where('exam_id',$request->exam_id)->get();
        foreach($examItems as $item)
        {
            $answer = ExamAnswer::where('exam_item_id',$item->id)->where('student_id',$request->student_id)->first();
            $totalScore += $answer->score;
        }

        $totalScore = $totalScore / count($examItems);
        return response()->json(["totalScore" => $totalScore],$this->success);
    }

    public function setStudentScore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'answer_scores'   =>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }

        foreach($request->answer_scores as $id => $score)
        {
            $answer = ExamAnswer::find($id);
            $answer->update([
                'score' => $score
            ]);
        }

        return response()->json(['success' => 1],$this->success);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'name'      	=>  'required',
            'exam_type'		=>  'required',
            'classroom_id'	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],422);
        }
        $input = $request->only('teacher_id','study_id','name','exam_type','classroom_id');
        $exam = Exam::create($input);
        return response()->json(['success'=>1],$this->success);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'id'            =>  'required',
            'teacher_id'    =>  'required',
            'study_id'      =>  'required',
            'name'      	=>  'required',
            'exam_type' 	=>  'required',
            'classroom_id'	=>  'required',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],401);
        }
        $input = $request->only('teacher_id','id','study_id','name','exam_type','classroom_id');
        $exam = Exam::find($request->id);
        if($exam->teacher_id == $request->teacher_id)
        {
	        $exam->update($input);
	        return response()->json(['success'=>1],$this->success);
	    }
	    return response()->json(['success'=>0],$this->success);
    }

    public function delete(Request $request){
        $exam = Exam::find($request->id);
        if($exam->teacher_id == $request->teacher_id)
        {
	        $exam->delete();
	        return response()->json(['success'=>1],$this->success);
        }
	    return response()->json(['success'=>0],$this->success);
    }
}
