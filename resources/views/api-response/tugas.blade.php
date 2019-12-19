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
                                        <p>{{$post->comment($user->id)->contents}}</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>