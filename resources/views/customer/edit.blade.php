@extends('layouts.dashboard')
@section('admin-customers','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Edit Customer</h2>
	            <form method="post" action="{{route('customer.update', $customer->id)}}">
	            	{{csrf_field()}}

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ $customer->name }}" placeholder="Enter Customer Name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control z-techno-el @error('email') is-invalid @enderror" name="email" value="{{ $customer->email }}" placeholder="Enter Customer's Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Customer Phone Number</label>
                        <input type="tel" class="form-control z-techno-el @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $customer->phone_number }}" placeholder="Enter Customer's Phone Number">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Date of Expired</label>
                        <input type="date" class="form-control z-techno-el @error('expired_at') is-invalid @enderror" name="expired_at" value="{{ $customer->expired_at }}" placeholder="Enter Select Date Expired">

                        @error('expired_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control z-techno-el @error('password') is-invalid @enderror" name="password" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('customer.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
