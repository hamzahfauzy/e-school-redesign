@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Roles</h2>
	            <p>
	            	<a href="{{route('role.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Create</a>
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
	            			<th>Roles Name</th>
	            			<th>Descriptions</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($roles) || count($roles) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($roles as $key => $role)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$role->name}}</td>
	            			<td><small>{{$role->description}}</small></td>
	            			<td>
	            				<form method="POST" action="{{route('role.delete', $role->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('role.edit', $role->id)}}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$roles->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
