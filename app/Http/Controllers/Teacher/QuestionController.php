<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Elearning\{Question, QuestionAnswer};

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = auth()->user()->questions()->paginate(10);
        return view('teacher.question.index',[
            'questions' => $questions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studies = auth()->user()->studies;
        return view('teacher.question.create',[
            'studies' => $studies
        ]);
    }

    public function createAnswer(Question $question)
    {
        if($question->user_id != auth()->user()->id)
            return redirect()->back();
        return view('teacher.question.create-answer',[
            'question' => $question
        ]);
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
        $this->validate($request,[
            'study' => 'required',
            'title' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);

        auth()->user()->questions()->create([
            'school_id' => auth()->user()->school[0]->id,
            'user_id' => auth()->user()->id,
            'study_id' => $request->study,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        return redirect()->route('teachers.questions.index')->with(['success' => 'Soal berhasil ditambahkan']);
    }

    public function storeAnswer(Request $request)
    {
        //
        $this->validate($request,[
            'description' => 'required',
        ]);

        QuestionAnswer::create([
            'school_id' => auth()->user()->school[0]->id,
            'question_id' => $request->question_id,
            'title' => $request->description,
        ]);

        return redirect()->route('teachers.questions.show',$request->question_id)->with(['success' => 'Jawaban berhasil ditambahkan']);
    }

    public function setAnswer(Question $question,$answer)
    {
        $question->update(['key_answer_id' => $answer]);
        return redirect()->route('teachers.questions.show',$question->id)->with(['success' => 'Jawaban benar berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        if($question->user_id != auth()->user()->id)
            return redirect()->back();
        return view('teacher.question.show',[
            'question' => $question
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if($question->user_id != auth()->user()->id)
            return redirect()->back();
        $studies = auth()->user()->studies;
        return view('teacher.question.edit',[
            'studies' => $studies,
            'question' => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'study' => 'required',
            'title' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);

        auth()->user()->questions()->find($request->id)->update([
            'school_id' => auth()->user()->school[0]->id,
            'user_id' => auth()->user()->id,
            'study_id' => $request->study,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        return redirect()->route('teachers.questions.index')->with(['success' => 'Soal berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        auth()->user()->questions()->find($request->id)->delete();

        return redirect()->route('teachers.questions.index')->with(['success' => 'Soal berhasil di hapus']);
    }

    public function destroyAnswer(Request $request)
    {
        auth()->user()->questions()->find($request->id)->answers()->find($request->answer_id)->delete();

        return redirect()->route('teachers.questions.show',$request->id)->with(['success' => 'Jawaban berhasil di hapus']);
    }
}
