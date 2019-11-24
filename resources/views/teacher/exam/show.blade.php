@extends('layouts.dashboard')
@section('teachers.exams.index','sidebar-active')
@section('site-title','- Kuis '.$exam->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Kuis {{$exam->name}}</h2>
	            <a href="{{route('teachers.exams.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
	            <p></p>
	            <div class="table-responsive">
	            	<table class="table">
	            		<tr>
	            			<th>#</th>
	            			<th>Siswa</th>
	            			<th>Nilai</th>
	            			<th>Status</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($exam->students) || count($exam->students) == 0)
	            		<tr>
	            			<td><i>Tidak ada data</i></td>
	            		</tr>
	            		@endif

	            		@foreach($exam->students as $key => $student)
	            		<tr>
	            			<td width="5%" align="center">{{++$key}}</td>
	            			<td>
	            				<a href="{{route('teachers.exams.result',[$exam->id, $student->id])}}">{{$student->name}}</a>
	            			</td>
	            			<td>
	            				@if($student->pivot->status == 3)
	            				{{$student->totalScore}}
	            				@else
	            				<i>Belum Penilaian</i>
	            				@endif
	            			</td>
	            			<td>
	            				@if($student->pivot->status == 1)
	            				<label class="badge badge-success">Sedang Mengerjakan</label>
	            				@elseif($student->pivot->status > 1 || \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
	            				<label class="badge badge-primary">Selesai</label>
	            				@endif
	            			</td>
	            			<td>
	            				@if($student->pivot->status > 1 || \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
	            				<a href="{{route('teachers.exams.result',[$exam->id, $student->id])}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Hasil</a>
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
