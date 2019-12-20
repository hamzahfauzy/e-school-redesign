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
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th width="50px">#</th>
	            			<th>Siswa</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($study->pivot->classroom->students) || count($study->pivot->classroom->students) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($study->pivot->classroom->students as $key => $student)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$student->name}}</td>
	            			<td>

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
