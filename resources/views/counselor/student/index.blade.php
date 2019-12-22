@extends('layouts.dashboard')
@section('counselors.students.index','sidebar-active')
@section('site-title','- Data Siswa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Siswa</h2>
	            <p></p>
	            @if(empty($students) || count($students) == 0)
	            <center>
	            	<i>Data not found!</i>
	            </center>
	            @endif
	            <div class="row">
	            	@foreach($students as $key => $student)
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
