@extends('layouts.dashboard')
@section('sistem-informasi.users.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Tambah Peran</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('sistem-informasi.users.save-role',$user->id)}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control z-techno-el" value="{{ $user->name }}" readonly="">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control z-techno-el @error('role_id') is-invalid @enderror" name="role_id" value="{{ old('role_id') }}">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                        @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('sistem-informasi.users.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
