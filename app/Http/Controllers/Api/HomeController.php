<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\User;
use App\Model\{Post, SchoolProfile, Role};
use App\Model\Elearning\Exam;
use App\Model\InformationSystem\{Major,Classroom};
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomeController extends Controller
{
    //

    public function retrievePosts(User $user)
    {
        if(!$user->isRole('admin_sistem_informasi') && !$user->isRole('admin'))
        {
            $response = new StreamedResponse(function() use ($user){
                while(true) {
                    $posts = [];
                    $school_id = 0;
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

                        $post = Post::whereIn('post_as',['Tugas','Materi','Pengumuman','Teman Sekelas'])->where('post_as_id',$user->getClassroom[0]->id)->get();
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

                    if($user->school && count($user->school) > 0)
                    {
                        $post = Post::where('post_as','Semua Orang')->where('school_id',$user->school[0]->id)->get();
                        foreach($post as $p)
                            $posts[] = $p->id;
                    }

                    if(isset($_GET['filter']))
                    {
                        $posts = Post::whereIn('id',$posts)->where('post_as',$_GET['filter'])->orderby('created_at','desc')->paginate(10)->setPath(route('api.get-posts'));
                    }
                    else
                        $posts = Post::whereIn('id',$posts)->orderby('created_at','desc')->paginate(10)->setPath(route('api.get-posts'));
                    // $last = Post::whereIn('id',$posts)->orderby('created_at','desc')->first();
                    $last = 0;
                    $all_posts = [];
                    $comments = [];
                    foreach($posts as $key => $post)
                    {
                        if($key == 0)
                            $last = $post->id;
                        $_comments = $post->comments()->orderby('id','desc')->get();
                        $comment_id = !empty($_comments) && count($_comments) > 0 ? $_comments[0]->id : 0;
                        $comments[] = [
                            'post_id'    => $post->id,
                            'comment_id' => $comment_id,
                            'html'       => (string) View::make('api-response.comment',[
                                            'comments' => $_comments,
                                            'user' => $user
                                        ])
                        ];
                        $all_posts[] = $post;
                    }
                    $data = json_encode([
                                        'id' => $last,
                                        'page' => isset($_GET['page']) ? $_GET['page'] : 1,
                                        'html' => (string) View::make('api-response.home',[
                                            'posts' => $posts,
                                            'user' => $user
                                        ])
                                    ]);

                    $data_comments = json_encode($comments);
                    echo "event: newPosts\n";
                    echo "data: " .$data. "\n\n";

                    echo "event: newComments\n";
                    echo "data: " .$data_comments. "\n\n";
                    ob_flush();
                    flush();
                    usleep(1000000);
                }
            });
            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('X-Accel-Buffering', 'no');
            $response->headers->set('Cach-Control', 'no-cache');
            return $response;
        }
    }

    public function findSchool($keyword)
    {
    	$schools = SchoolProfile::where('name','like','%'.$keyword.'%')->orwhere('school_id','like','%'.$keyword.'%')->get();
    	return response()->json($schools);
    }

    public function findMajors(SchoolProfile $school)
    {
    	return response()->json($school->majors);
    }

    public function findUsers(Request $request)
    {
        $school = SchoolProfile::find($request->school_id);
        $users = $school->users()->where('name','LIKE','%'.$request->name.'%')->where('users.id','!=',$request->user_id)->get();
        return response()->json([
            'html' => (string) View::make('api-response.users',[
                'users' => $users
            ])
        ]);
    }

    public function findClassrooms(SchoolProfile $school, Major $major)
    {
    	return response()->json($major->class_rooms);
    }

    public function finishRegistration(Request $request)
    {
    	$user = User::find($request->user_id);
    	$role = Role::where('slug',$request->role)->first();
        if(!$user->roles()->wherePivot('role_id',$role->id)->first())
    	   $user->roles()->attach($role);
    	$school = SchoolProfile::find($request->school);
        if(!$user->school()->wherePivot('school_id',$school->id)->first())
    	   $user->school()->attach($school);

    	if($request->role == 'siswa')
    	{
    		$classroom = Classroom::find($request->classroom);
            if(!$user->getClassroom()->wherePivot('classroom_id',$classroom->id)->first())
                $user->getClassroom()->attach($classroom);
    	}

    	return response()->json(['success' => 1]);
    }

    public function getPosts(Request $request)
    {
        $posts = [];
        $user = User::find($request->user_id);
        $school_id = 0;
        if($user->isRole('admin_sistem_informasi') || $user->isRole('admin'))
        {
            return response()->json([
                'id' => 0,
                'all_posts' => [],
                'html' => ''
            ]);
        }
        else
        {
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

                $post = Post::whereIn('post_as',['Tugas','Materi','Pengumuman','Teman Sekelas'])->where('post_as_id',$user->getClassroom[0]->id)->get();
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

            if($user->school && count($user->school) > 0)
            {
    	        $post = Post::where('post_as','Semua Orang')->where('school_id',$user->school[0]->id)->get();
    	        foreach($post as $p)
    	            $posts[] = $p->id;
            }

            if(isset($_GET['filter']))
            {
                $posts = Post::whereIn('id',$posts)->where('post_as',$_GET['filter'])->orderby('created_at','desc')->paginate(10);
            }
            else
                $posts = Post::whereIn('id',$posts)->orderby('created_at','desc')->paginate(10);
            // $last = Post::whereIn('id',$posts)->orderby('created_at','desc')->first();
            $last = 0;
            $all_posts = [];
            foreach($posts as $key => $post)
            {
                if($key == 0)
                    $last = $post->id;
                $all_posts[] = $post;
            }

            return response()->json([
                'id' => $last,
                'all_posts' => $all_posts,
                'html' => (string) View::make('api-response.home',[
                    'posts' => $posts,
                    'user' => $user
                ])
            ]);
        }

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

    function loadSinglePost(User $user, Post $post)
    {
        return response()->json([
            'html' => (string) View::make('api-response.post',[
                'post' => $post,
                'user' => $user,
            ])
        ]);
    }

    function loadComments(Post $post)
    {
        return response()->json([
            'html' => (string) View::make('api-response.comments',[
                'post' => $post,
            ])
        ]);
    }

    function chats(Request $request)
    {
        $user_id = $request->user_id;
        $chats = Post::where('post_as','chats')->where('user_id',$user_id)->orwhere('post_as_id',$user_id)->orderby('updated_at','desc')->get();
        $latest = !empty($chats) && count($chats) > 0 ? $chats[0]->id : 0;
        $activeChat = !empty($chats) && count($chats) > 0 ? $chats[0] : [];
        return response()->json([
            'id' => $latest,
            'activeChat' => $activeChat,
            'all_chats' => $chats,
            'html' => (string) View::make('api-response.chats',[
                'chats' => $chats,
                'user_id' => $user_id,
            ])
        ]);
    }

    function retrieveChats(User $user)
    {
        $response = new StreamedResponse(function() use ($user){
            while(true) {
                $chats = Post::where('post_as','chats')->where('user_id',$user->id)->orwhere('post_as_id',$user->id)->orderby('updated_at','desc')->get();
                $latest = 0;
                // $latest = !empty($chats) && count($chats) > 0 ? $chats[0]->id : 0;
                $comments = [];
                foreach($chats as $key => $post)
                {
                    if($key == 0)
                        $latest = $post->id;
                    $_comments = $post->comments()->orderby('id','asc')->get();
                    $last_comments = $post->comments()->orderby('id','desc')->get();
                    $comment_id = !empty($last_comments) && count($last_comments) > 0 ? $last_comments[0]->id : 0;
                    $comments[] = [
                        'post_id'    => $post->id,
                        'contents' => !empty($last_comments) && count($last_comments) > 0 ? $last_comments[0]->contents : 0,
                        'comment_id' => $comment_id,
                        'html'       => (string) View::make('api-response.comment',[
                                        'comments' => $_comments,
                                        'user' => $user
                                    ])
                    ];
                }
                $data = json_encode([
                    'id' => $latest,
                    'all_chats' => $chats,
                    'html' => (string) View::make('api-response.chats',[
                        'chats' => $chats,
                        'user_id' => $user->id,
                    ])
                ]);

                $data_comments = json_encode($comments);

                echo "event: newChats\n";
                echo "data: " .$data. "\n\n";

                echo "event: newMessage\n";
                echo "data: " .$data_comments. "\n\n";
                ob_flush();
                flush();
                usleep(1000000);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        return $response;
    }

    function postChat(Request $request)
    {
        if(isset($request->id))
            $chat = Post::find($request->id);
        else
            $chat = Post::where('post_as','chats')
                    ->where('user_id',$request->user_id)
                    ->where('post_as_id',$request->post_as_id)
                    ->orwhere('user_id',$request->post_as_id)
                    ->where('post_as_id',$request->user_id)
                    ->first();

        if(!empty($chat))
        {
            $chat->update([
                'contents' => $request->message
            ]);

            $chat->comments()->create([
                'post_id' => $chat->id,
                'user_id' => $request->user_id,
                'contents' => $request->message
            ]);
        }
        else
        {
            $chat = Post::create([
                'school_id' => $request->school_id,
                'user_id' => $request->user_id,
                'contents' => $request->message,
                'post_as' => 'chats',
                'post_as_id' => $request->post_as_id
            ]);

            $chat->comments()->create([
                'post_id' => $chat->id,
                'user_id' => $request->user_id,
                'contents' => $request->message
            ]);
        }

        return response()->json(['success'=>1]);
    }
}
