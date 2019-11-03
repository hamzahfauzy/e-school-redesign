@extends('layouts.dashboard')
@section('sistem-informasi.classrooms.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Siswa Kelas {{$classroom->name}}</h2>
	            <p>
	            	<a href="{{route('sistem-informasi.classrooms.students.create',$classroom->id)}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Siswa</a>
	            	<a href="{{route('sistem-informasi.classrooms.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
	            </p>
	            @if ($message = Session::get('success'))
			      <div class="alert alert-success alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{{ $message }}</strong>
			      </div>
			    @endif
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th>#</th>
	            			<th>Siswa</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($students) || count($students) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($students as $key => $student)
	            		<tr>
	            			<td width="10%">{{++$key}}</td>
	            			<td>{{$student->name}}</td>
	            			<td>
	            				<form method="POST" action="{{route('sistem-informasi.classrooms.students.delete', [$classroom->id,$student->id])}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$students->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
