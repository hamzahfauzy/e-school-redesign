@if(!empty($chats) && count($chats) > 0)
@foreach($chats as $chat)
<div class="chat-items chat-id-{{$chat->id}}" onclick="setActiveChat('{{$chat->id}}')">
    <div class="author-picture">
        @if($chat->user_id == $user_id)
            @if($chat->userto->picture)
            <img src="{{asset('uploads/schools/'.$chat->userto->school[0]->id.'/'.$chat->userto->id.'/'.$chat->userto->picture)}}" width="100%">
            @else
            <img src="{{asset('assets/default.png')}}" width="100%">
            @endif
        @else
            @if($chat->user->picture)
            <img src="{{asset('uploads/schools/'.$chat->user->school[0]->id.'/'.$chat->user->id.'/'.$chat->user->picture)}}" width="100%">
            @else
            <img src="{{asset('assets/default.png')}}" width="100%">
            @endif
        @endif
    </div>
    <div class="comment-content chat-list">
        <div class="author-name">
            @if($chat->user_id == $user_id)
            <h4 style="margin: 0;"><a href="{{route('profile')}}">{{$chat->userto->name}}</a></h4>
            @else
            <h4 style="margin: 0;"><a href="#">{{$chat->user->name}}</a></h4>
            @endif
            <small>{{$chat->updated_at->format('j F Y H:i:s')}}</small>
        </div>
        <p>{{nl2br($chat->contents)}}</p>
    </div>
</div>
@endforeach
@else
<i>Tidak ada pesan</i>
@endif