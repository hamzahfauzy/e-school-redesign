@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Create New Customer</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('customer.store')}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter Customer Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Customer's Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Customer Phone Number</label>
                        <input type="phone_number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Customer's Phone Number">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<div class="form-group">
	            		<label>Date of Expired</label>
	            		<input type="date" class="form-control @error('expired_at') is-invalid @enderror" name="expired_at" value="{{ old('expired_at') }}" placeholder="Enter Select Date Expired">

                        @error('expired_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>


	            	<div class="form-group">
	            		<label>Password</label>
	            		<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
	            	</div>

	            	<button class="btn btn-sm btn-success">Submit</button>
	            	<a href="{{route('customer.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
