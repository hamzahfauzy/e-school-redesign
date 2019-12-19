<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\{Exam,ExamAnswer};
use App\User;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $exams = auth()->user()->getClassroom[0]->exams()->orderby('id','desc')->get();
        $ids = [];
        foreach($exams as $exam)
        {
            if($exam->start_at)
                $ids[] = $exam->id;
        }

        $exams = Exam::whereIn('id',$ids)->orderby('id','desc')->paginate(10);
        foreach($exams as $exam)
        {
            $exam->student = $exam->students()->where('student_id',auth()->user()->id)->first();
            $totalScore = 0;
            foreach($exam->questions as $question)
            {
                $answer = ExamAnswer::where('exam_item_id',$question->pivot->id)->where('student_id',auth()->user()->id)->first();
                if(empty($answer))
                    continue;

                $totalScore += $answer->score;
            }

            if($totalScore != 0 && $exam->questions()->count())
                $totalScore = number_format($totalScore / $exam->questions()->count(),2);

            $exam->totalScore = $totalScore;
        }

        return view('student.exam.index',[
            'exams' => $exams
        ]);
    }

    public function result(Exam $exam, User $student)
    {
        if($student->id != auth()->user()->id)
            return redirect()->back();

        $data = [];
        $totalScore = 0;
        foreach($exam->questions as $question)
        {
            $answer = ExamAnswer::where('exam_item_id',$question->pivot->id)->where('student_id',$student->id)->first();
            if(empty($answer))
                continue;
            $data[] = [
                'question' => $question,
                'answer'   => $answer
            ];

            $totalScore += $answer->score;
        }

        if($totalScore != 0 && $exam->questions()->count())
            $totalScore = number_format($totalScore / $exam->questions()->count(),2);

        $examStudent = $exam->students()->where('student_id',$student->id)->first();

        return view('student.exam.result',[
            'data' => $data,
            'totalScore' => $totalScore,
            'student' => $student,
            'examStudent' => $examStudent,
            'exam' => $exam
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        // check is exam in same classroom
        if($exam->classroom_id != auth()->user()->getClassroom[0]->id)
            return redirect()->back();

        // check is exam is active
        $now = \Carbon\Carbon::now();
        $examChecker = $exam->where('start_at','<',$now)->where('finish_at','>',$now)->first();
        if(empty($examChecker))
            return redirect()->route('students.exams.index');

        $checker = $exam->students()->where('student_id',auth()->user()->id)->first();
        if(empty($checker))
        {
            $exam->students()->attach(auth()->user(),['school_id'=>auth()->user()->school[0]->id,'status'=>1]);
            $checker = $exam->students()->where('student_id',auth()->user()->id)->first();
        }
        else
        {
            if($checker->pivot->status == 2)
                return redirect()->route('students.exams.index');
        }

        return view('student.exam.show',[
            'exam' => $exam
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
