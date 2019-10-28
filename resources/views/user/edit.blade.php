@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Edit User</h2>
	            <form method="post" action="{{route('user.update', $user->id)}}">
	            	{{csrf_field()}}

                    <div class="form-group">
                        <label>Name</label>
                        <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" placeholder="Enter user Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" placeholder="Enter user's Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn btn-sm btn-success">Submit</button>
	            	<a href="{{route('user.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
