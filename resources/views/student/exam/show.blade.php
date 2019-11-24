@extends('layouts.dashboard')
@section('students.exams.index','sidebar-active')
@section('site-title','- Panel Kuis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <exam id="{{$exam->id}}" student_id="{{auth()->user()->id}}"/>
	        </div>
        </div>
    </div>
</div>
@endsection
