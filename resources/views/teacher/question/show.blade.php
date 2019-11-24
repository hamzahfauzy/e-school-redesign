@extends('layouts.dashboard')
@section('teachers.questions.index','sidebar-active')
@section('site-title','- Jawaban Soal '.$question->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Jawaban Soal {{$question->title}}</h2>
	            <p>
	            	<a href="{{route('teachers.questions.answer.create',$question->id)}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Jawaban</a>
	            	<a href="{{route('teachers.questions.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
	            </p>
	            @if ($message = Session::get('success'))
			      <div class="alert alert-success alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{{ $message }}</strong>
			      </div>
			    @endif

			    @if ($question->key_answer_id == null)
			      <div class="alert alert-warning alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>Soal ini belum memiliki jawaban benar</strong>
			      </div>
			    @endif
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th>#</th>
	            			<th>Jawaban</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($question->answers) || count($question->answers) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($question->answers as $key => $answer)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>
	            				{{$answer->title}}<br>
	            				@if($answer->id == $question->key_answer_id)
	            				<span class="badge badge-success">Jawaban Benar</span>
	            				@endif
	            			</td>
	            			<td>
	            				<form method="POST" action="{{route('teachers.questions.answer.delete')}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
								    <input type="hidden" name="id" value="{{$question->id}}">
								    <input type="hidden" name="answer_id" value="{{$answer->id}}">
								    @if($question->key_answer_id == null || $answer->id != $question->key_answer_id)
		            				<a onclick="if(!confirm('Anda yakin untuk membuat jawaban ini sebagai jawaban yang benar?')){ return false; }" href="{{route('teachers.questions.answer.update', [$question->id,$answer->id])}}" class="btn z-techno-btn btn-success"><i class="fa fa-check"></i> Jawaban Benar</a>
		            				@endif
								    <button onclick="if(!confirm('Apa anda yakin akan menghapus jawaban ini?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
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
