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
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th width="50px">#</th>
	            			<th>Siswa</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($students) || count($students) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($students as $key => $student)
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
