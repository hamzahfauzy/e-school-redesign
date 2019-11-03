@extends('layouts.dashboard')
@section('admin-users','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>User</h2>
	            <p>
	            	<a href="{{route('user.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create User</a>
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
	            			<th>Name</th>
	            			<th>E-Mail</th>
	            			<th>Status</th>
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
								<div class="dropdown">
								  <button class="btn z-techno-btn 
									@if($user->status==0)
										btn-secondary
								  	@else
								  		btn-success
									@endif

								   dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  	@if($user->status==0)
										In Active
								  	@else
								  		Active
									@endif
								  </button>
								  <div class="dropdown-menu z-techno-el" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="{{route('user.inactive', $user->id) }}">@if($user->status==0) <i class="fa fa-check"></i> @endif Inactvie</a>
								    <a class="dropdown-item" href="{{route('user.active', $user->id)}}">@if($user->status==1) <i class="fa fa-check"></i> @endif Active</a>
								</div>
  	            			</td>
	            			<td>
	            				<form method="POST" action="{{route('user.delete', $user->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('user.edit', $user->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$users->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
