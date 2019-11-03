@extends('layouts.dashboard')
@section('sistem-informasi.roles.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Data Peran e-School</h2>
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th>#</th>
	            			<th>Roles Name</th>
	            			<th>Descriptions</th>
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
