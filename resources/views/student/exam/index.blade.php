@extends('layouts.dashboard')
@section('students.exams.index','sidebar-active')
@section('site-title','- Kuis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Kuis</h2>

	            <div class="table-responsive">
	            	<table class="table">
	            		@if(empty($exams) || count($exams) == 0)
	            		<tr>
	            			<td><i>Tidak ada data</i></td>
	            		</tr>
	            		@endif

	            		@foreach($exams as $key => $exam)
	            		<tr>
	            			<td>
	            				{{++$key}} 
	            			</td>
	            			<td>
	            				<span class="badge badge-success">{{$exam->type}}</span>
	            				@if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
	            				<span class="badge z-techno-primary">{{$exam->type}} akan dimulai pada {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}</span>
	            				@endif

	            				@if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
		                        <span class="badge badge-success">{{$exam->type}} sedang berlangsung</span>
		                        @endif

	            				@if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
	            				<span class="badge badge-primary">{{$exam->type}} Selesai</span>
	            				@endif
	            				<br>
	            				<a href="{{route('students.exams.show', $exam->id)}}"><b>{{$exam->name}}</b></a>
	            				<p>
	            					Mata Pelajaran : {{$exam->study->name}}<br>
	            					Guru : {{$exam->teacher->name}}<br>
	            					Soal : {{$exam->questions()->count()}}<br>
	            					Pilihan Berganda : {{$exam->questions()->where('type','Pilihan Berganda')->count()}}<br>
	            					Essay : {{$exam->questions()->where('type','Essay')->count()}}
	            				</p>
	            				@if($exam->student && ($exam->student->pivot->status == 3 || $exam->student->pivot->status == 2))
	            				<a href="javascript:void()" class="btn z-techno-btn z-techno-secondary">Nilai Kamu {{$exam->totalScore}}</a>
	            				<a href="{{route('students.exams.result',[$exam->id,auth()->user()->id])}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-eye"></i> Hasil</a>
	            				@else
	            				<a href="javascript:void()" class="btn z-techno-btn z-techno-secondary">{{$exam->type}} telah selesai dan kamu tidak mengikutinya</a>
	            				@endif
		                        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
		                        <a href="{{route('students.exams.show', $exam->id)}}" class="btn z-techno-btn btn-success"><i class="fa fa-eye"></i> Ikuti {{$exam->type}}</a>
		                        @endif
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$exams->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
