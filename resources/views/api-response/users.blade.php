                        @if(!empty($users) && count($users) > 0)
                        @foreach($users as $user)
                        <div class="person-response-item" onclick="setMessageTo('{{$user->id}}','{{$user->name}}',this)">
                            <div class="author-picture">
                                @if($user->picture)
                                <img src="{{asset('uploads/schools/'.$user->school[0]->id.'/'.$user->id.'/'.$user->picture)}}" width="100%">
                                @else
                                <img src="{{asset('assets/default.png')}}" width="100%">
                                @endif
                            </div>
                            <div class="author-name">
                                <h4 style="margin: 0;margin-top: 15px;"><a href="javascript:void(0)">{{$user->name}}</a></h4>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="person-response-item">
                            <center><i>Tidak ada pesan</i></center>
                        </div>
                        @endif