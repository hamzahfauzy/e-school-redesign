@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Edit Product</h2>
	            <form method="post" action="{{route('product.update', $product->id)}}">
	            	{{csrf_field()}}
	            	<div class="form-group">
	            		<label>Product Name</label>
	            		<input type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" placeholder="Enter Product Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<div class="form-group">
	            		<label>Price</label>
	            		<input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $product->price }}"  placeholder="Enter Price in Rupiah">

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<div class="form-group">
	            		<label>Unit</label>
	            		<input type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ $product->unit }}" placeholder="Enter Unit">

                        @error('unit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<div class="form-group">
	            		<label>Unit Value</label>
	            		<input type="number" class="form-control @error('unit_value') is-invalid @enderror" name="unit_value" value="{{ $product->unit_value }}" placeholder="Enter Unit Value">

                        @error('unit_value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<button class="btn btn-sm btn-success">Submit</button>
	            	<a href="{{route('product.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
