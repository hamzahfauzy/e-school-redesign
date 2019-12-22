@extends('layouts.dashboard')
@section('teachers.study.index','sidebar-active')
@section('site-title','- Tampil Mata Pelajaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Mata Pelajaran</h2>
	            <a href="{{route('teachers.study.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
	            <p></p>
	            <table class="table table-bordered">
	            	<tr>
	            		<td width="100px">Nama</td>
	            		<td>{{$study->name}}</td>
	            	</tr>
	            	<tr>
	            		<td>Kelas</td>
	            		<td>{{$study->pivot->classroom->name}}</td>
	            	</tr>
	            	<tr>
	            		<td>Jurusan</td>
	            		<td>{{$study->pivot->classroom->major->name}}</td>
	            	</tr>
	            </table>
	            <p></p>
	            @if(empty($study->pivot->classroom->students) || count($study->pivot->classroom->students) == 0)
	            <center>
	            	<i>Data not found!</i>
	            </center>
	            @endif
	            <div class="row">
	            	@foreach($study->pivot->classroom->students as $key => $student)
	            	<div class="col-sm-12 col-md-6">
	            		<div class="user-container">
	            			<div class="user-picture">
	            				@if($student->picture)
	            				<img src="{{asset('uploads/schools/'.$student->school[0]->id.'/'.$student->id.'/'.$student->picture)}}" width="100%">
	            				@else
	            				<img src="{{asset('assets/default.png')}}" width="100%">
	            				@endif
	            			</div>
	            			<div class="user-detail">
	            				<b>{{$student->name}}</b>
	            				<br>
	            				<i>{{$student->email}}</i>
	            			</div>
	            		</div>
	            	</div>
	            	@endforeach
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
