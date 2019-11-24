<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\{Exam,ExamItem};

class ExamItemController extends Controller
{

    function check($obj)
    {
        if($obj->user_id != auth()->user()->id)
            return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam)
    {
        $this->check($exam);

        $questions = $exam->questions()->paginate(10);
        return view('teacher.exam.question.index',[
            'questions' => $questions,
            'exam' => $exam
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Exam $exam)
    {
        $this->check($exam);

        $questions = auth()->user()->questions()->paginate(10);
        return view('teacher.exam.question.create',[
            'exam' => $exam,
            'questions' => $questions
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exam $exam)
    {
        $this->check($exam);
        $question = auth()->user()->questions()->find($request->id);
        $exam->questions()->attach($question);
        return redirect()->route('teachers.exams.items.index',$exam->id)->with(['success' => 'Soal Kuis berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request,Exam $exam)
    {
        $this->check($exam);
        $question = auth()->user()->questions()->find($request->id);
        $exam->questions()->detach($question);
        return redirect()->route('teachers.exams.items.index',$exam->id)->with(['success' => 'Soal Kuis berhasil dihapus']);
    }
}
