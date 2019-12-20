@extends('layouts.dashboard')
@section('students.exams.index','sidebar-active')
@section('site-title','- Hasil '.$exam->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Hasil {{$exam->name}}</h2>
	            <a href="" class="btn z-techno-btn btn-secondary"><i class="fa fa-print"></i> Cetak</a>
	            <a href="{{route('students.exams.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
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

	            				<b>{{$value['question']->title}}</b>
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
		            				{!! !empty($value['answer']) ? nl2br($value['answer']->question_answer_text) : '<i>Tidak terjawab</i>' !!}<br>
		            			</p>
		            			@else
		            				@if (!empty($value['answer']) && filter_var($value['answer']->answer->title, FILTER_VALIDATE_URL))
		            					<div class="h_iframe">
										    <iframe src="{{$value['question']->description}}" frameborder="0" allowfullscreen></iframe>
										</div>
		            				@else
			            			<p>
			            				{!! !empty($value['answer']) ? $value['answer']->answer->title : '<i>Tidak terjawab</i>' !!}<br>
			            			</p>
		            				@endif
		            			@endif

		           			</td>
		           		</tr>
		           		@endforeach
		           	</table>
		        </div>
	        </div>
        </div>
    </div>
</div>
@endsection
