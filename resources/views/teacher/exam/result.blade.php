@extends('layouts.dashboard')
@section('teachers.exams.index','sidebar-active')
@section('site-title','- Hasil '.$exam->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Hasil {{$exam->name}}</h2>

	            @if ($message = Session::get('success'))
				    <div class="alert alert-success alert-block">
				        <button type="button" class="close" data-dismiss="alert">×</button> 
				        <strong>{{ $message }}</strong>
				    </div>
				@endif

				@if($examStudent->pivot->status == 3)
	            <a href="" class="btn z-techno-btn btn-secondary"><i class="fa fa-print"></i> Cetak</a>
	            <a href="{{route('teachers.exams.show',$exam->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
				@endif

				@if($examStudent->pivot->status < 3)
	            <form method="post" action="{{route('teachers.exams.save-result')}}" onsubmit="return confirm('Apakah anda yakin menyimpan nilai ini?')">
	            	{{csrf_field()}}
	            	<input type="hidden" name="exam_id" value="{{$exam->id}}">
	            	<input type="hidden" name="student_id" value="{{$student->id}}">
	            	<button class="btn z-techno-btn btn-primary"><i class="fa fa-check"></i> Simpan Penilaian</button>
	            @endif
	            	<p></p>
		            <table class="table table-striped">
		            	<tr>
		            		<td>Siswa</td>
		            		<td>{{$student->name}}</td>
		            	</tr>
		            	<tr>
		            		<td>Email</td>
		            		<td>{{$student->email}}</td>
		            	</tr>
		            	<tr>
		            		<td>Kelas / Jurusan</td>
		            		<td>{{$student->getClassroom[0]->name}} / {{$student->getClassroom[0]->major->name}}</td>
		            	</tr>
		            	@if($examStudent->pivot->status == 3)
		            	<tr>
		            		<td>Total Nilai</td>
		            		<td>{{$totalScore}}</td>
		            	</tr>
		            	@endif
		            </table>
		            
	            	<p></p>
		            <div class="table-responsive">
		            	<table class="table">
		            		@if(empty($data) || count($data) == 0)
		            		<tr>
		            			<td><i>Tidak ada data</i></td>
		            		</tr>
		            		@endif

		            		@foreach($data as $key => $value)
		            		<tr>
		            			<td>
		            				{{++$key}} 
		            			</td>
		            			<td>
		            				<span class="badge badge-success">{{$value['question']->type}}</span>
		            				@if($value['answer']->score > 0 && $value['question']->type == 'Pilihan Berganda')
		            				<label class="badge badge-primary"><i class="fa fa-check"></i></label>
		            				@elseif($value['answer']->score > 0 && $value['question']->type == 'Essay' && $examStudent->pivot->status == 3)
		            				<label class="badge badge-primary"><i class="fa fa-check"></i> {{$value['answer']->score}}</label>
		            				@elseif($value['answer']->score > 0 && $value['question']->type == 'Essay' && $examStudent->pivot->status < 3)
		            				<label class="badge badge-warning">Belum di Nilai</label>
		            				@elseif($value['answer']->score == NULL && $value['question']->type == 'Essay')
		            				<label class="badge badge-warning">Belum di Nilai</label>
		            				@else
		            				<label class="badge badge-danger"><i class="fa fa-times"></i> Jawaban Salah</label>
		            				@endif
		            				<br>

		            				<a href="{{route('teachers.questions.show', $value['question']->id)}}"><b>{{$value['question']->title}}</b></a>
		            				@if (filter_var($value['question']->description, FILTER_VALIDATE_URL))
		            				<div class="h_iframe">
										<iframe src="{{$value['question']->description}}" frameborder="0" allowfullscreen></iframe>
									</div>
		            				@else
		            				<p>{{nl2br($value['question']->description)}}</p>
		            				@endif
		            				
		            				<label>Jawaban:</label><br>
		            				@if($value['question']->type == 'Essay')
		            				<p>
		            					{{$value['answer']->question_answer_text}}<br>
		            				</p>
		            				@else
		            					@if (filter_var($value['answer']->answer->title, FILTER_VALIDATE_URL))
		            						<div class="h_iframe">
											    <iframe src="{{$value['question']->description}}" frameborder="0" allowfullscreen></iframe>
											</div>
		            					@else
			            				<p>
			            					{{$value['answer']->answer->title}}<br>
			            				</p>
		            					@endif
		            				@endif

		            				@if($value['question']->type == 'Essay' && $examStudent->pivot->status < 3)
		            				<br>
		            				<div class="form-group">
		            					<label>Nilai</label>
		            					<select class="form-control z-techno-el" name="nilai[{{$value['answer']->id}}]" required="">
		            						<option value="">- Pilih -</option>
		            						@foreach([0,0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9,1] as $nilai)
		            						<option value="{{$nilai}}">{{$nilai}}</option>
		            						@endforeach
		            					</select>
		            				</div>
		            				@endif
		            			</td>
		            		</tr>
		            		@endforeach
		        			@if($examStudent->pivot->status < 3)
		            		<tr>
		            			<td></td>
		            			<td>
		        					<button class="btn z-techno-btn btn-primary"><i class="fa fa-check"></i> Simpan Penilaian</button>
		            			</td>
		            		</tr>
		            		@endif
		            	</table>
		            </div>
		        @if($examStudent->pivot->status < 3)
		        </form>
		        @endif
	        </div>
        </div>
    </div>
</div>
@endsection
