@extends('layouts.dashboard')
@section('sistem-informasi.teachers.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Guru</h2>
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
	            			<th>Name</th>
	            			<th>E-Mail</th>
	            			<th>Role</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($users) || count($users) == 0)
	            		<tr>
	            			<td colspan="5"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($users as $key => $user)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$user->name}}</td>
	            			<td>{{$user->email}}</td>
	            			<td>
	            				<a href="{{route('sistem-informasi.users.add-role',$user->id)}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i></a>
	            				@foreach($user->roles as $role)
	            				<a onclick="if(!confirm('Apakah anda yakin menghapus peran {{$role->name}} dari user {{$user->name}} ?')){ return false; }else{ document.getElementById('delete-role-{{$user->id}}-{{$role->id}}').submit() }" href="javascript:void(0)" class="btn z-techno-btn btn-danger"><i class="fa fa-minus"></i></a><span class="btn z-techno-btn btn-primary">{{$role->name}}</span> 
	            				<form method="POST"  action="{{route('sistem-informasi.users.delete-role', $user->id)}}" id="delete-role-{{$user->id}}-{{$role->id}}">
	            					{{ csrf_field() }}
								    {{ method_field('DELETE') }}
								    <input type="hidden" name="role_id" value="{{$role->id}}">
	            				</form>
	            				@endforeach
	            			</td>
	            			<td>
	            				<form method="POST" action="{{route('sistem-informasi.users.delete', $user->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('sistem-informasi.users.edit', $user->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
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
