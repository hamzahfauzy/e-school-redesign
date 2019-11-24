@extends('layouts.dashboard')
@section('sistem-informasi.classrooms.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Mata Pelajaran Kelas {{$classroom->name}}</h2>
	            <p>
	            	<a href="{{route('sistem-informasi.classrooms.studies.create',$classroom->id)}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Mata Pelajaran</a>
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
	            			<th>Mata Pelajaran</th>
	            			<th>Guru Pengampuh</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($studies) || count($studies) == 0)
	            		<tr>
	            			<td colspan="4"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($studies as $key => $study)
	            		<tr>
	            			<td width="10%">{{++$key}}</td>
	            			<td>{{$study->name}}</td>
	            			<td>{{$study->pivot->teacher->name}}</td>
	            			<td>
	            				<form method="POST" action="{{route('sistem-informasi.classrooms.studies.delete', [$classroom->id,$study->id])}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
								    <a href="{{route('sistem-informasi.classrooms.studies.edit',[$classroom->id,$study->id])}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$studies->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
