            @foreach($posts as $post)
            @if($user->isRole('siswa'))
            @if($post->exam())
            <?php $exam=$post->exam() ?>
            <div class="content-wrapper">
                <div class="author-section">
                    <div class="author-picture">
                        @if($exam->teacher->picture)
                        <img src="{{asset('uploads/schools/'.$exam->teacher->school[0]->id.'/'.$exam->teacher->id.'/'.$exam->teacher->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4><a href="#">{{$exam->teacher->name}}</a></h4>
                        <span class="badge badge-success">{{$exam->type}}</span> <small>{{$exam->updated_at->format('j F Y H:i:s')}}</small>
                    </div>
                </div>

                <div class="post-section">
                    Mata Pelajaran : {{$exam->study->name}}<br>
                    Kelas : {{$exam->classroom->name}}<br>
                    Soal : {{$exam->questions()->count()}}<br>
                    Pilihan Berganda : {{$exam->questions()->where('type','Pilihan Berganda')->count()}}<br>
                    Essay : {{$exam->questions()->where('type','Essay')->count()}}
                    <br>
                    Mulai : {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}<br>
                    Selesai : {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)}}
                </div>

                <div class="post-meta">
                    @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
                    <button class="btn z-techno-btn z-techno-primary">{{$exam->type}} akan dimulai pada {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}</button>
                    @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                    <a href="{{route('students.exams.show', $exam->id)}}" class="btn z-techno-btn btn-success">Ikuti {{$exam->type}}</a>
                    @else
                    <button class="btn z-techno-btn z-techno-secondary">{{$exam->type}} Selesai</button>
                    <a href="{{route('students.exams.result',[$exam->id,$user->id])}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Hasil</a>
                    @endif
                </div>
            </div>
            <br>
            @else
            @if($post->post_as == 'Tugas')
            <div class="content-wrapper">
                <div class="author-section">
                    <div class="author-picture">
                        @if($post->user->picture)
                        <img src="{{asset('uploads/schools/'.$post->user->school[0]->id.'/'.$post->user->id.'/'.$post->user->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4><a href="{{$user->id == $post->user->id ? route('profile') : '#'}}">{{$post->user->name}}</a></h4>
                        <span class="badge badge-success">{{$post->post_as}}</span> <small>{{$post->updated_at->format('j F Y H:i:s')}}</small>
                    </div>
                </div>

                <div class="post-section">
                    <p>{{$post->contents}}</p>
                </div>

                <div class="post-meta">
                    @if(empty($post->comments()->where('user_id',$user->id)->first()))
                    <form id="form-comment-{{$post->id}}" method="post" onsubmit="saveComment(this); return false;">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <textarea placeholder="Jawab Tugas Disini..." name="contents" class="form-control z-techno-el" rows="3" style="resize: none;"></textarea>
                        </div>
                        <button class="btn z-techno-btn z-techno-primary">Jawab Tugas</button>
                    </form>
                    @else
                    <button class="btn z-techno-btn z-techno-primary" data-toggle="modal" data-target="#modalJawaban{{$post->id}}">Lihat Jawaban</button>
                    <!-- Modal -->
                    <div class="modal fade" id="modalJawaban{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="border-radius: 0px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Jawaban Tugas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div style="padding: 15px;border:1px solid #eaeaea;">
                                        <p>{{$post->comment($user->id)->contents}}</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <br>
            @else
            <div class="content-wrapper">
                <div class="author-section">
                    <div class="author-picture">
                        @if($post->user->picture)
                        <img src="{{asset('uploads/schools/'.$post->user->school[0]->id.'/'.$post->user->id.'/'.$post->user->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4><a href="{{$user->id == $post->user->id ? route('profile') : '#'}}">{{$post->user->name}}</a></h4>
                        <span class="badge badge-success">{{$post->post_as}}</span> <small>{{$post->updated_at->format('j F Y H:i:s')}}</small>
                    </div>
                </div>

                <div class="post-section">
                    <p>{{$post->contents}}</p>
                </div>

                <div class="post-meta">
                    
                </div>
            </div>
            <br>
            @endif
            @endif
            @elseif($user->isRole('guru'))
            @if($post->exam())
            <?php $exam=$post->exam() ?>
            <div class="content-wrapper">
                <div class="author-section">
                    <div class="author-picture">
                        @if($exam->teacher->picture)
                        <img src="{{asset('uploads/schools/'.$exam->teacher->school[0]->id.'/'.$exam->teacher->id.'/'.$exam->teacher->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4><a href="{{route('profile')}}">{{$exam->teacher->name}}</a></h4>
                        <span class="badge badge-success">{{$exam->type}}</span> <small>{{$exam->updated_at->format('j F Y H:i:s')}}</small>
                    </div>
                </div>

                <div class="post-section">
                    Mata Pelajaran : {{$exam->study->name}}<br>
                    Kelas : {{$exam->classroom->name}}<br>
                    Soal : {{$exam->questions()->count()}}<br>
                    Pilihan Berganda : {{$exam->questions()->where('type','Pilihan Berganda')->count()}}<br>
                    Essay : {{$exam->questions()->where('type','Essay')->count()}}
                    <br>
                    Mulai : {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}<br>
                    Selesai : {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)}}
                </div>

                <div class="post-meta">
                    <a href="{{route('teachers.exams.items.index',$exam->id)}}" class="btn z-techno-btn z-techno-primary">Lihat Soal</a>
                    @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
                    <button class="btn z-techno-btn z-techno-primary">{{$exam->type}} akan dimulai pada {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}</button>
                    @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                    <button class="btn z-techno-btn btn-success">Lihat {{$exam->type}}</button>
                    @else
                    <button class="btn z-techno-btn z-techno-secondary">{{$exam->type}} Selesai</button>
                    <a href="{{route('teachers.exams.show',$exam->id)}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Hasil</a>
                    @endif
                </div>
            </div>
            <br>
            @else
            <div class="content-wrapper">
                <div class="author-section">
                    <div class="author-picture">
                        @if($post->user->picture)
                        <img src="{{asset('uploads/schools/'.$post->user->school[0]->id.'/'.$post->user->id.'/'.$post->user->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4><a href="{{route('profile')}}">{{$post->user->name}}</a></h4>
                        <span class="badge badge-success">{{$post->post_as}}</span> <small>{{$post->updated_at->format('j F Y H:i:s')}}</small>
                    </div>
                </div>

                <div class="post-section">
                    <p>{{$post->contents}}</p>
                </div>

                <div class="post-meta">
                    @if($post->post_as == 'Tugas')
                    <button class="btn z-techno-btn z-techno-primary" data-toggle="modal" data-target="#modal{{$post->id}}">Lihat Jawaban</button>
                    <!-- Modal -->
                    <div class="modal fade" id="modal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="border-radius: 0px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Jawaban Tugas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @foreach($post->comments as $comment)
                                    <div style="padding: 15px;border:1px solid #eaeaea;">
                                        <a href="#"><b>{{$comment->user->name}}</b></a>
                                        <p>{{$comment->contents}}</p>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <br>
            @endif
            @endif
            @endforeach

            {{$posts->links()}}