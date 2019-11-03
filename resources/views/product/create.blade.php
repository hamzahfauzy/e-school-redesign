@extends('layouts.dashboard')
@section('admin-products','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Create New Product</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('product.store')}}">
	            	{{csrf_field()}}
	            	<div class="form-group">
	            		<label>Product Name</label>
	            		<input type="name" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter Product Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<div class="form-group">
	            		<label>Price</label>
	            		<input type="number" class="form-control z-techno-el @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="Enter Price in Rupiah">

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<div class="form-group">
	            		<label>Unit</label>
	            		<input type="text" class="form-control z-techno-el @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit') }}" placeholder="Enter Unit">

                        @error('unit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<div class="form-group">
	            		<label>Unit Value</label>
	            		<input type="number" class="form-control z-techno-el @error('unit_value') is-invalid @enderror" name="unit_value" value="{{ old('unit_value') }}" placeholder="Enter Unit Value">

                        @error('unit_value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('product.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
