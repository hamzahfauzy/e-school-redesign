@extends('layouts.dashboard')
@section('admin-roles','sidebar-active')

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
                        <input type="name" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ $role->name }}" placeholder="Enter Role Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control z-techno-el @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') ? old('slug') : $role->slug}}" placeholder="Enter Slug">

                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control z-techno-el @error('description') is-invalid @enderror" name="description" placeholder="Enter Description">{{ $role->description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('role.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
