@extends('layouts.dashboard')
@section('teachers.questions.index','sidebar-active')
@section('site-title','- Bank Soal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Bank Soal</h2>
	            <p>
	            	<a href="{{route('teachers.questions.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Soal</a>
	            </p>
	            @if ($message = Session::get('success'))
			      <div class="alert alert-success alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{{ $message }}</strong>
			      </div>
			    @endif
	            <div class="table-responsive">
	            	<table class="table">
	            		@if(empty($questions) || count($questions) == 0)
	            		<tr>
	            			<td><i>Tidak ada data</i></td>
	            		</tr>
	            		@endif

	            		@foreach($questions as $key => $question)
	            		<tr>
	            			<td>
	            				{{++$key}} 
	            			</td>
	            			<td>
	            				<span class="badge badge-success">{{$question->type}}</span><br>
	            				@if($question->type == 'Essay')
	            				<a href="javascript:void(0)"><b>{{$question->title}}</b></a>
	            				@else
	            				<a href="{{route('teachers.questions.show', $question->id)}}"><b>{{$question->title}}</b></a>
	            				@endif
	            				<p>{{nl2br($question->description)}}</p>
	            				<form method="POST" action="{{route('teachers.questions.delete')}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
								    <input type="hidden" name="id" value="{{$question->id}}">
								    @if($question->type == "Pilihan Berganda")
		            				<a href="{{route('teachers.questions.show', $question->id)}}" class="btn z-techno-btn btn-success"><i class="fa fa-eye"></i> Jawaban</a>
		            				@endif
		            				<a href="{{route('teachers.questions.edit', $question->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$questions->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
