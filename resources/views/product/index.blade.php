@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Products</h2>

	            <a href="{{route('product.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Create</a>
	            <p></p>
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
	            			<th></th>
	            		</tr>
	            		@if(empty($products) || count($products) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($products as $key => $product)
	            		<tr>
	            			<td>{{++$key}}</td>
	            			<td>{{$product->name}}</td>
	            			<td>
	            				<a href="{{route('product.edit',$product->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
	            				<a href="{{route('product.edit',$product->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
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
