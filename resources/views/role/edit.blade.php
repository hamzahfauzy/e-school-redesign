@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Edit Product</h2>
	            <form method="post" action="{{route('role.update', $role->id)}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $role->name }}" placeholder="Enter Role Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Enter Description">{{ $role->description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


	            	<button class="btn btn-sm btn-success">Submit</button>
	            	<a href="{{route('role.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
