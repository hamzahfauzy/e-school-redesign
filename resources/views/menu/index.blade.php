@extends('layouts.dashboard')
@section('admin-menus','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Menus</h2>
	            <p>
	            	<a href="{{route('menu.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create</a>
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
	            			<th>Menu Name</th>
	            			<th>Role</th>
	            			<th>Route Name</th>
	            			<th>Ordered Number</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($menus) || count($menus) == 0)
	            		<tr>
	            			<td colspan="6"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($menus as $key => $menu)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$menu->name}}</td>
	            			<td>{{$menu->role->name}}</td>
	            			<td>{{$menu->route}}</td>
	            			<td>{{$menu->ordered_number}}</td>
	            			<td>
		            			<a href="{{route('menu.edit', $menu->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
		            			<a href="javascript:void(0)" onclick="if(!confirm('Are you sure to delete?')){ return false; }else{ document.getElementById('form-delete-{{$menu->id}}').submit()}" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
	            				<form method="POST" action="{{route('menu.delete', $menu->id)}}" id="form-delete-{{$menu->id}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$menus->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
