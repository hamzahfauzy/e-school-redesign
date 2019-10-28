@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>User</h2>
	            <p>
	            	<a href="{{route('user.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Create User</a>
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
	            			<th></th>
	            		</tr>
	            		@if(empty($users) || count($users) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($users as $key => $user)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$user->name}}</td>
	            			<td>{{$user->email}}</td>
	            			<td>
	            				<form method="POST" action="{{route('user.delete', $user->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('user.edit', $user->id)}}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
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
