<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Model\Post;
use App\Model\Elearning\Exam;

class HomeController extends Controller
{
    //

    public function getPosts(Request $request)
    {
        $posts = [];
        $user = User::find($request->user_id);
        if($user->isRole('siswa'))
        {
            $now = \Carbon\Carbon::now();
            $exams = Exam::where('start_at','<',$now)->where('finish_at','>',$now)->get();

            foreach($exams as $exam)
            {
                $checker = $exam->students()->where('student_id',$user->id)->first();
                if(!empty($checker))
                    return redirect()->route('students.exams.show', $exam->id);
            }

            $data = $user->getClassroom[0]->exams()->where('start_at','!=','NULL')->get();
            foreach($data as $val)
            {
                if($val->post())
                    $posts[] = $val->post()->id;
            }

            $post = Post::whereIn('post_as',['Tugas','Pengumuman','Semua Orang','Teman Sekelas'])->where('post_as_id',$user->getClassroom[0]->id)->get();
            foreach($post as $p)
                $posts[] = $p->id;

            $post = Post::where('post_as','Catatan Pribadi')->where('user_id',$user->id)->get();
            foreach($post as $p)
                $posts[] = $p->id;
        }

        if($user->isRole('guru'))
        {
            $data = $user->exams()->where('start_at','!=','NULL')->get();
            foreach($data as $val)
            {
                if($val->post())
                    $posts[] = $val->post()->id;
            }

            $post = Post::whereIn('post_as',['Catatan Pribadi','Pengumuman','Tugas','Materi'])->where('user_id',$user->id)->get();
            foreach($post as $p)
                $posts[] = $p->id;
        }

        $posts = Post::whereIn('id',$posts)->orderby('created_at','desc')->paginate(10);
        return view('api-response.home',[
            'posts' => $posts,
            'user' => $user
        ]);
    }

    function savePost(Request $request)
    {
    	$user = User::find($request->user_id);
    	if($user->isRole('guru'))
    	{
	    	if($request->post_as != 'Catatan Pribadi')
	    	{
		    	$post = Post::create([
		            'school_id' => $user->school[0]->id,
		            'user_id' => $user->id,
		            'contents' => $request->contents,
		            'post_as' => $request->post_as,
		            'post_as_id' => $request->post_as_id,
		            'file_url' => '',
		            'image_url' => '',
		        ]);
	    	}
	    	else
	    	{
	    		$post = Post::create([
		            'school_id' => $user->school[0]->id,
		            'user_id' => $user->id,
		            'contents' => $request->contents,
		            'post_as' => $request->post_as,
		            'post_as_id' => 0,
		            'file_url' => '',
		            'image_url' => '',
		        ]);
	    	}
    	}

    	if($user->isRole('siswa'))
    	{
	    	if($request->post_as == 'Catatan Pribadi')
	    	{
	    		$post = Post::create([
		            'school_id' => $user->school[0]->id,
		            'user_id' => $user->id,
		            'contents' => $request->contents,
		            'post_as' => $request->post_as,
		            'post_as_id' => 0,
		            'file_url' => '',
		            'image_url' => '',
		        ]);
	    	}

	    	if($request->post_as == 'Semua Orang')
	    	{
		    	$post = Post::create([
		            'school_id' => $user->school[0]->id,
		            'user_id' => $user->id,
		            'contents' => $request->contents,
		            'post_as' => $request->post_as,
		            'post_as_id' => 0,
		            'file_url' => '',
		            'image_url' => '',
		        ]);
	    	}

	    	if($request->post_as == 'Teman Sekelas')
	    	{
	    		$class_id = $user->classrooms[0]->id;
		    	$post = Post::create([
		            'school_id' => $user->school[0]->id,
		            'user_id' => $user->id,
		            'contents' => $request->contents,
		            'post_as' => $request->post_as,
		            'post_as_id' => $class_id,
		            'file_url' => '',
		            'image_url' => '',
		        ]);
	    	}
    	}

    	return response()->json(['success'=>1]);
    }

    function saveComment(Request $request)
    {
    	$post = Post::find($request->post_id);
    	$post->comments()->create([
    		'post_id' => $request->post_id,
    		'user_id' => $request->user_id,
    		'contents' => $request->contents,
    	]);

    	return response()->json(['success'=>1]);
    }
}
