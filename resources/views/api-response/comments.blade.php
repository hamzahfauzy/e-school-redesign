@foreach($post->comments as $comment)
<div style="padding: 15px;border:1px solid #eaeaea;">
    <a href="#"><b>{{$comment->user->name}}</b></a><br>
    <small>{{$comment->created_at->format('j F Y H:i:s')}}</small>
    <p>{{nl2br($comment->contents)}}</p>
</div>
@endforeach