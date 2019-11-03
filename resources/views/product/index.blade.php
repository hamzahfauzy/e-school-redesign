@extends('layouts.dashboard')
@section('admin-products','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Products</h2>
	            <p>
	            	<a href="{{route('product.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Create</a>
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
	            			<th>Price</th>
	            			<th>Unit</th>
	            			<th>Unit Value</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($products) || count($products) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($products as $key => $product)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$product->name}}</td>
	            			<td>@rupiah($product->price)</td>
	            			<td>{{$product->unit}}</td>
	            			<td>{{$product->unit_value}}</td>
	            			<td>
	            				<form method="POST" action="{{route('product.delete', $product->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<a href="{{route('product.edit', $product->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$products->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
