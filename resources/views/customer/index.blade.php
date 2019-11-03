@extends('layouts.dashboard')
@section('admin-customers','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Customers</h2>
	            <p>
	            	<a href="{{route('customer.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create User Customer</a>
	            	<a href="{{route('customer.new')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> New Customer</a>
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
	            			<th>Phone Number</th>
	            			<th>E-Mail</th>
	            			<th>Status</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($customers) || count($customers) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($customers as $key => $customer)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$customer->name}}</td>
	            			<td>{{$customer->phone_number}}</td>
	            			<td>{{$customer->email}}</td>
	            			<td>
								<div class="dropdown">
								  <button class="btn z-techno-btn 
									@if($customer->status==0)
										btn-secondary
								  	@elseif($customer->status==1)
								  		btn-success
								  	@else
								  		btn-danger
									@endif

								   dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  	@if($customer->status==0)
										Disabled
								  	@elseif($customer->status==1)
								  		Activated
								  	@else
								  		Expired
									@endif
								  </button>
								  <div class="dropdown-menu z-techno-el" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="{{route('customer.disable', $customer->id) }}">@if($customer->status==0) <i class="fa fa-check"></i> @endif Disable</a>
								    <a class="dropdown-item" href="{{route('customer.active', $customer->id)}}">@if($customer->status==1) <i class="fa fa-check"></i> @endif Active</a>
								    <a class="dropdown-item" href="{{route('customer.expired', $customer->id)}}">@if($customer->status==2) <i class="fa fa-check"></i> @endif Expired</a>
								</div>
  	            			</td>
	            			<td>
	            				<form method="POST" action="{{route('customer.delete', $customer->user_id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('customer.edit', $customer->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$customers->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
