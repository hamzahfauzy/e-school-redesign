<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\Post;
use App\Model\Elearning\Exam;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = [];
        if(auth()->user()->isRole('siswa'))
        {
            $now = \Carbon\Carbon::now();
            $exams = Exam::where('start_at','<',$now)->where('finish_at','>',$now)->get();

            foreach($exams as $exam)
            {
                $checker = $exam->students()->where('student_id',auth()->user()->id)->first();
                if(!empty($checker))
                    return redirect()->route('students.exams.show', $exam->id);
            }

            $data = auth()->user()->getClassroom[0]->exams()->where('start_at','!=','NULL')->get();
            foreach($data as $val)
            {
                if($val->post())
                    $posts[] = $val->post()->id;
            }

            $post = Post::whereIn('post_as',['Pengumuman','Tugas','Materi'])->where('post_as_id',auth()->user()->getClassroom[0]->id)->get();
            foreach($post as $p)
                $posts[] = $p->id;
        }

        if(auth()->user()->isRole('guru'))
        {
            $data = auth()->user()->exams()->where('start_at','!=','NULL')->get();
            foreach($data as $val)
            {
                if($val->post())
                    $posts[] = $val->post()->id;
            }

            $post = Post::whereIn('post_as',['Pengumuman','Tugas','Materi'])->where('user_id',auth()->user()->id)->get();
            foreach($post as $p)
                $posts[] = $p->id;
        }

        $posts = Post::whereIn('id',$posts)->orderby('created_at','desc')->paginate();
        return view('home',[
            'posts' => $posts
        ]);
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        if(auth()->user()->isRole('admin_sistem_informasi'))
        {
            auth()->user()->customer()->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);


        if($request->password)
        {
            auth()->user()->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->route('profile')->with(['success' => 'Data Anda berhasil di update']);
    }

    public function profileUpload(Request $request)
    {
        $this->validate($request,[
            'picture' => 'required'
        ]);

        if(auth()->user()->isRole('admin_sistem_informasi'))
        {
            $destinationPath = public_path()."/uploads/schools/".auth()->user()->customer->school->id;
            $file = $request->file('picture');
            $file->move($destinationPath, $file->getClientOriginalName());
            auth()->user()->customer()->update([
                'picture' => $file->getClientOriginalName(),
            ]);
        }
        else
        {
            $destinationPath = public_path()."/uploads/schools/".auth()->user()->school[0]->id."/".auth()->user()->id;
            if(!file_exists($destinationPath))
                mkdir($destinationPath);
            $file = $request->file('picture');
            $file->move($destinationPath, $file->getClientOriginalName());
            auth()->user()->update([
                'picture' => $file->getClientOriginalName(),
            ]);
        }
        

        return redirect()->back();
    }

    function step($step)
    {
        if(auth()->user()->school && count(auth()->user()->school) > 0)
            return redirect()->route('home');

        return view('step-1');
    }
}
