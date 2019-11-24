@extends('layouts.dashboard')
@section('sistem-informasi.classrooms.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Kelas</h2>
	            <p>
	            	<a href="{{route('sistem-informasi.classrooms.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Kelas</a>
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
	            			<th>Nama</th>
	            			<th>Jurusan</th>
	            			<th>Wali Kelas</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($classrooms) || count($classrooms) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($classrooms as $key => $classroom)
	            		<tr>
	            			<td align="center">
	            				{{++$key}}
	            			</td>
	            			<td>{{$classroom->name}}</td>
	            			<td>{{$classroom->major->name}}</td>
	            			<td>{{$classroom->teacher->name}}</td>
	            			<td>
	            				<form method="POST" action="{{route('sistem-informasi.classrooms.delete', $classroom->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('sistem-informasi.classrooms.show', $classroom->id)}}" class="btn z-techno-btn btn-success"><i class="fa fa-eye"></i> Siswa</a>
		            				<a href="{{route('sistem-informasi.classrooms.show-studies', $classroom->id)}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Mata Pelajaran</a>
		            				<a href="{{route('sistem-informasi.classrooms.edit', $classroom->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i></a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i></button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$classrooms->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
