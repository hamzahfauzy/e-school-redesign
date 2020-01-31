            @foreach($posts as $post)
            @if($user->isRole('siswa'))
            @if($post->exam())
            <?php 
            $exam=$post->exam();
            $exam->student = $exam->students()->where('student_id',$user->id)->first();
            ?>
            <div class="content-wrapper post-id-{{$post->id}}">
                <div class="author-section">
                    <div class="author-picture">
                        @if($exam->teacher->picture)
                        <img src="{{asset('uploads/schools/'.$exam->teacher->school[0]->id.'/'.$exam->teacher->id.'/'.$exam->teacher->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4 style="margin:0;"><a href="#">{{$exam->teacher->name}}</a></h4>
                        <small>{{$exam->updated_at->format('j F Y H:i:s')}}</small><br>
                        <span class="badge badge-success">{{$exam->type}}</span>
                        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                        <span class="badge badge-warning">{{$exam->type}} Selesai</span>
                        @endif
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

                <div class="post-meta" id="post-meta-{{$post->id}}">
                    @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
                    <button class="btn z-techno-btn z-techno-primary">{{$exam->type}} akan dimulai pada {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}</button>
                    @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                    <a href="{{route('students.exams.show', $exam->id)}}" class="btn z-techno-btn btn-success">Ikuti {{$exam->type}}</a>
                    @else
                    @if($exam->student && (($exam->student->pivot->status == 3 || $exam->student->pivot->status == 2) || ($exam->start_at && $exam->finish_at && \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))))
                    <a href="{{route('students.exams.result',[$exam->id,$user->id])}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Hasil</a>
                    @endif
                    
                    @if(!$exam->student && $exam->start_at && $exam->finish_at && \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                    <a href="javascript:void()" class="btn z-techno-btn z-techno-secondary">{{$exam->type}} telah selesai dan kamu tidak mengikutinya</a>
                    @endif
                    @endif
                </div>
            </div>
            <br>
            @else
            <div class="content-wrapper post-id-{{$post->id}}">
                <div class="author-section">
                    <div class="author-picture">
                        @if($post->user->picture)
                        <img src="{{asset('uploads/schools/'.$post->user->school[0]->id.'/'.$post->user->id.'/'.$post->user->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4 style="margin:0;"><a href="{{$user->id == $post->user->id ? route('profile') : '#'}}">{{$post->user->name}}</a></h4>
                        <small>{{$post->updated_at->format('j F Y H:i:s')}}</small><br>
                        @if($post->post_as == 'Tugas')
                        <span class="badge badge-success"><a href="{{route('students.assignments.index')}}" style="color: #FFF;text-decoration: none;">{{$post->post_as}}</a></span>
                        @else
                        <span class="badge badge-success">{{$post->post_as}}</span>
                        @endif
                    </div>
                </div>

                <div class="post-section">
                    <?php 
                    $text = $post->contents;
                    $html_links = preg_replace_callback('"\b(https?://\S+)"', 'App\MyHelper::get', $text);
                    $post->contents = $html_links;
                    ?>
                    <p>{!! nl2br($post->contents) !!}</p>
                </div>

                <div class="post-meta" id="post-meta-{{$post->id}}">
                    @if($post->post_as == 'Tugas')
                    @if(empty($post->comments()->where('user_id',$user->id)->first()))
                    <form id="form-comment-{{$post->id}}" method="post" onsubmit="saveComment(this); return false;">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="type" value="Tugas">
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

                                        <small>{{$post->comment($user->id)->created_at->format('j F Y H:i:s')}}</small>
                                        <p>{!!nl2br($post->comment($user->id)->contents)!!}</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @elseif($post->post_as == 'Semua Orang')
                    <form id="form-comment-{{$post->id}}" method="post" onsubmit="saveComment(this); return false;">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <textarea placeholder="Komentar Disini..." name="contents" class="form-control z-techno-el" style="resize: none;"></textarea>
                        </div>
                        <button class="btn z-techno-btn z-techno-primary">Poskan Komentar</button>
                    </form>
                    <p></p>

                    <a href="javascript:void(0)" id="btn-show-comment-{{$post->id}}" onclick="document.getElementById('post-comment-{{$post->id}}').style.display = 'block';document.getElementById('btn-hide-comment-{{$post->id}}').style.display = 'block';this.style.display = 'none';">Tampilkan Komentar</a>
                    <a href="javascript:void(0)" id="btn-hide-comment-{{$post->id}}" onclick="document.getElementById('post-comment-{{$post->id}}').style.display = 'none';document.getElementById('btn-show-comment-{{$post->id}}').style.display = 'block';this.style.display = 'none';" style="display: none;">Sembunyikan Komentar</a>
                    @if(!empty($post->comments) && count($post->comments) > 0)
                    <div class="post-comment" id="post-comment-{{$post->id}}" style="display: none;">
                        @foreach($post->comments()->orderby('id','desc')->get() as $comment)
                        <div class="post-comment-items">
                            <div class="author-picture">
                                @if($comment->user->picture)
                                <img src="{{asset('uploads/schools/'.$comment->user->school[0]->id.'/'.$comment->user->id.'/'.$comment->user->picture)}}" width="100%">
                                @else
                                <img src="{{asset('assets/default.png')}}" width="100%">
                                @endif
                            </div>
                            <div class="author-name">
                                <h4 style="margin: 0;"><a href="{{$user->id == $post->user->id ? route('profile') : '#'}}">{{$comment->user->name}}</a></h4>
                                <small>{{$comment->updated_at->format('j F Y H:i:s')}}</small>
                            </div>

                            <p>{!!nlbr($comment->contents)!!}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="post-comment" id="post-comment-{{$post->id}}" style="display: none;"><i>Tidak ada komentar</i></div>
                    @endif

                    @endif
                </div>
            </div>
            <br>
            @endif
            @elseif($user->isRole('guru'))
            @if($post->exam())
            <?php $exam=$post->exam() ?>
            <div class="content-wrapper post-id-{{$post->id}}">
                <div class="author-section">
                    <div class="author-picture">
                        @if($exam->teacher->picture)
                        <img src="{{asset('uploads/schools/'.$exam->teacher->school[0]->id.'/'.$exam->teacher->id.'/'.$exam->teacher->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4 style="margin:0;"><a href="{{route('profile')}}">{{$exam->teacher->name}}</a></h4>
                        <small>{{$exam->updated_at->format('j F Y H:i:s')}}</small><br>
                        <span class="badge badge-success">{{$exam->type}}</span> 
                        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                        <span class="badge badge-warning">{{$exam->type}} Selesai</span>
                        @endif
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

                <div class="post-meta" id="post-meta-{{$post->id}}">
                    <a href="{{route('teachers.exams.items.index',$exam->id)}}" class="btn z-techno-btn z-techno-primary">Lihat Soal</a>
                    @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
                    <button class="btn z-techno-btn z-techno-primary">{{$exam->type}} akan dimulai pada {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}</button>
                    @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
                    <button class="btn z-techno-btn btn-success">Lihat {{$exam->type}}</button>
                    @else
                    <a href="{{route('teachers.exams.show',$exam->id)}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Hasil</a>
                    @endif
                </div>
            </div>
            <br>
            @else
            <div class="content-wrapper post-id-{{$post->id}}">
                <div class="author-section">
                    <div class="author-picture">
                        @if($post->user->picture)
                        <img src="{{asset('uploads/schools/'.$post->user->school[0]->id.'/'.$post->user->id.'/'.$post->user->picture)}}" width="100%">
                        @else
                        <img src="{{asset('assets/default.png')}}" width="100%">
                        @endif
                    </div>
                    <div class="author-name">
                        <h4 style="margin:0;"><a href="{{$user->id == $post->user->id ? route('profile') : '#'}}">{{$post->user->name}}</a></h4>
                        <small>{{$post->updated_at->format('j F Y H:i:s')}}</small><br>
                        @if($post->post_as == 'Tugas')
                        <span class="badge badge-success">{{$post->post_as}} > {{$post->classroom()->name}}</span>
                        @else
                        <span class="badge badge-success">{{$post->post_as}}</span>
                        @endif
                    </div>
                </div>

                <div class="post-section">
                    <?php 
                    $text = $post->contents;
                    $html_links = preg_replace_callback('"\b(https?://\S+)"', 'App\MyHelper::get', $text);
                    // $html_links = preg_replace('"\b(https?://\S+)"', '<a href="$1" target="_blank">$1</a>', $text);
                    $post->contents = $html_links;
                    ?>
                    <p>{!! nl2br($post->contents) !!}</p>
                </div>

                <div class="post-meta" id="post-meta-{{$post->id}}">
                    @if($post->post_as == 'Tugas')
                    <button class="btn z-techno-btn z-techno-primary" onclick="loadComments('{{$post->id}}')" data-toggle="modal" data-target="#modal{{$post->id}}">Lihat Jawaban</button>
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
                                <div class="modal-body" id="post-comment-{{$post->id}}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($post->post_as == 'Semua Orang')
                    <form id="form-comment-{{$post->id}}" method="post" onsubmit="saveComment(this); return false;">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="form-group">
                            <textarea placeholder="Komentar Disini..." name="contents" class="form-control z-techno-el" style="resize: none;"></textarea>
                        </div>
                        <button class="btn z-techno-btn z-techno-primary">Poskan Komentar</button>
                    </form>
                    <p></p>

                    <a href="javascript:void(0)" id="btn-show-comment-{{$post->id}}" onclick="document.getElementById('post-comment-{{$post->id}}').style.display = 'block';document.getElementById('btn-hide-comment-{{$post->id}}').style.display = 'block';this.style.display = 'none';">Tampilkan Komentar</a>
                    <a href="javascript:void(0)" id="btn-hide-comment-{{$post->id}}" onclick="document.getElementById('post-comment-{{$post->id}}').style.display = 'none';document.getElementById('btn-show-comment-{{$post->id}}').style.display = 'block';this.style.display = 'none';" style="display: none;">Sembunyikan Komentar</a>
                    @if(!empty($post->comments) && count($post->comments) > 0)
                    <div class="post-comment" id="post-comment-{{$post->id}}" style="display: none;">
                        @foreach($post->comments()->orderby('id','desc')->get() as $comment)
                        <div class="post-comment-items">
                            <div class="author-picture">
                                @if($comment->user->picture)
                                <img src="{{asset('uploads/schools/'.$comment->user->school[0]->id.'/'.$comment->user->id.'/'.$comment->user->picture)}}" width="100%">
                                @else
                                <img src="{{asset('assets/default.png')}}" width="100%">
                                @endif
                            </div>
                            <div class="author-name">
                                <h4 style="margin: 0;"><a href="{{$user->id == $comment->user->id ? route('profile') : '#'}}">{{$comment->user->name}}</a></h4>
                                 <small>{{$comment->updated_at->format('j F Y H:i:s')}}</small>
                            </div>

                            <p>{!!nl2br($comment->contents)!!}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="post-comment" id="post-comment-{{$post->id}}" style="display: none;"><i>Tidak ada komentar</i></div>
                    @endif

                    @endif
                </div>
            </div>
            <br>
            @endif
            @endif
            @endforeach

            {{$posts->links()}}