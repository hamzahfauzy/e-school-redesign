<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Elearning\{Exam, ExamAnswer};
use App\Model\Post;
use App\User;

class ExamController extends Controller
{

    public function __construct()
    {
        $this->exam = new Exam;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $exams = auth()->user()->exams()->paginate(20);
        return view('teacher.exam.index',[
            'exams' => $exams
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
        $studies = auth()->user()->studies;
        return view('teacher.exam.create',[
            'studies' => $studies
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
            'name' => 'required',
            'type' => 'required',
        ]);

        $study = DB::table('classroom_study')->where('id', $request->study)->first();
        
        $exam = $this->exam->create([
            'user_id' => auth()->user()->id,
            'school_id' => auth()->user()->school[0]->id,
            'classroom_id' => $study->classroom_id,
            'study_id' => $study->study_id,
            'name' => $request->name,
            'type' => $request->type
        ]);

        if($request->start_at)
            $exam->update(['start_at' => $request->start_at]);

        if($request->finish_at)
            $exam->update(['finish_at' => $request->finish_at]);

        return redirect()->route('teachers.exams.index')->with(['success' => 'Kuis berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
        if($exam->user_id != auth()->user()->id)
            return redirect()->back();
        foreach($exam->students as $student)
        {
            $totalScore = 0;
            foreach($exam->questions as $question)
            {
                $answer = ExamAnswer::where('exam_item_id',$question->pivot->id)->where('student_id',$student->id)->first();
                if(empty($answer))
                    continue;

                $totalScore += $answer->score;
            }

            if($totalScore != 0 && $exam->questions()->count())
                $totalScore = number_format($totalScore / $exam->questions()->count(),2);

            $student->totalScore = $totalScore;
        }
        return view('teacher.exam.show',[
            'exam' => $exam
        ]);
    }

    public function result(Exam $exam, User $student)
    {
        if($exam->user_id != auth()->user()->id)
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

        return view('teacher.exam.result',[
            'data' => $data,
            'totalScore' => $totalScore,
            'student' => $student,
            'examStudent' => $examStudent,
            'exam' => $exam
        ]);

    }

    public function saveResult(Request $request)
    {
        //
        $exam = Exam::find($request->exam_id);
        $student = $exam->students()->where('student_id',$request->student_id)->first();
        $student->pivot->status = 3;
        $student->pivot->save();

        foreach ($request->nilai as $key => $value) {
            $answer = ExamAnswer::find($key);
            $answer->score = $value;
            $answer->save();
        }

        return redirect()->route('teachers.exams.result',[$request->exam_id,$request->student_id])->with(['success' => 'Penilaian Berhasil disimpan']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        if($exam->user_id != auth()->user()->id)
            return redirect()->back();

        $studies = auth()->user()->studies;
        return view('teacher.exam.edit',[
            'studies' => $studies,
            'exam' => $exam
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
            'name' => 'required',
            'type' => 'required',
        ]);

        $study = DB::table('classroom_study')->where('id', $request->study)->first();
        
        $exam = $this->exam->find($request->id);
        $exam->update([
            'classroom_id' => $study->classroom_id,
            'study_id' => $study->study_id,
            'name' => $request->name,
            'type' => $request->type
        ]);

        if($request->start_at)
            $exam->update(['start_at' => $request->start_at]);

        if($request->finish_at)
            $exam->update(['finish_at' => $request->finish_at]);

        return redirect()->route('teachers.exams.index')->with(['success' => 'Kuis berhasil diupdate']);
    }

    public function publish(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'start_at' => 'required',
            'finish_at' => 'required|after:start_at',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $exam = $this->exam->find($request->id);
        if($exam->user_id != auth()->user()->id)
            return response()->json(['errors' => [0 => 'cheater detected :)']]);

        $exam->update([
            'start_at' => $request->start_at,
            'finish_at' => $request->finish_at,
        ]);

        $post = Post::create([
            'school_id' => auth()->user()->school[0]->id,
            'user_id' => auth()->user()->id,
            'contents' => '',
            'post_as' => $exam->type,
            'post_as_id' => $exam->id,
            'file_url' => '',
            'image_url' => '',
        ]);

        return response()->json(['success' => 'Kuis berhasil di publish']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $exam = $this->exam->find($request->id);
        if($exam->user_id != auth()->user()->id)
            return redirect()->back();

        $exam->delete();
        return redirect()->route('teachers.exams.index')->with(['success' => 'Kuis berhasil dihapus']);
    }
}
