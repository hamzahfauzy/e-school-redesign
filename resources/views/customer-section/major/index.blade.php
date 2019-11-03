@extends('layouts.dashboard')
@section('sistem-informasi.majors.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Jurusan</h2>
	            <p>
	            	<a href="{{route('sistem-informasi.majors.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Jurusan</a>
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
	            			<th></th>
	            		</tr>
	            		@if(empty($majors) || count($majors) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($majors as $key => $major)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$major->name}}</td>
	            			<td>
	            				<form method="POST" action="{{route('sistem-informasi.majors.delete', $major->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('sistem-informasi.majors.edit', $major->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$majors->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
