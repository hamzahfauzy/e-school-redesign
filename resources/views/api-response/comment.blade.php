                        @if(!empty($comments) && count($comments) > 0)
                        @foreach($comments as $comment)
                        <div class="post-comment-items">
                            <div class="author-picture">
                                @if($comment->user->picture)
                                <img src="{{asset('uploads/schools/'.$comment->user->school[0]->id.'/'.$comment->user->id.'/'.$comment->user->picture)}}" width="100%">
                                @else
                                <img src="{{asset('assets/default.png')}}" width="100%">
                                @endif
                            </div>
                            <div class="comment-content">
                                <div class="author-name">
                                    <h4 style="margin: 0;"><a href="{{$user->id == $comment->user->id ? route('profile') : '#'}}">{{$comment->user->name}}</a></h4>
                                    <small>{{$comment->updated_at->format('j F Y H:i:s')}}</small>
                                </div>

                                <p>{{$comment->contents}}</p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <i>Tidak ada komentar</i>
                        @endif