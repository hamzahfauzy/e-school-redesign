@extends('layouts.dashboard')
@section('admin-customers','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>New Customer</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('customer.nstore')}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control z-techno-el @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}">
                            <option value="">-- Select User --</option>
                            @foreach($users as $user)
                                @if($user->customer)
                                    @continue
                                @endif
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Customer Phone Number</label>
                        <input type="phone_number" class="form-control z-techno-el @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Customer's Phone Number">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<div class="form-group">
	            		<label>Date of Expired</label>
	            		<input type="date" class="form-control z-techno-el @error('expired_at') is-invalid @enderror" name="expired_at" value="{{ old('expired_at') }}" placeholder="Enter Select Date Expired">

                        @error('expired_at')
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
