@extends('layouts.dashboard')
@section('admin-menus','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Edit Menu</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('menu.update',$menu->id)}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control z-techno-el @error('role_id') is-invalid @enderror" name="role_id">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{$role->id == $menu->role_id ? 'selected' : ''}}>{{ $role->name }}</option>
                            @endforeach
                        </select>

                        @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $menu->name }}" placeholder="Enter Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<div class="form-group">
	            		<label>Route</label>
	            		<input type="text" class="form-control z-techno-el @error('route') is-invalid @enderror" name="route" value="{{ old('route') ? old('route') : $menu->route }}" placeholder="Enter Route">

                        @error('route')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

                    <div class="form-group">
                        <label>Ordered Number</label>
                        <input type="number" class="form-control z-techno-el @error('ordered_number') is-invalid @enderror" name="ordered_number" value="{{ old('ordered_number') ? old('ordered_number') : $menu->ordered_number }}" placeholder="Enter Name">

                        @error('ordered_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('menu.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
