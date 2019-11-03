@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
        		<h2>Profile</h2>

        		@if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

                @if(auth()->user()->customer)
        		<form method="post" action="{{route('profile.update')}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->customer->name }}" placeholder="Enter Customer Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control z-techno-el @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->customer->email }}" placeholder="Enter Customer's Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Customer Phone Number</label>
                        <input type="tel" class="form-control z-techno-el @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ auth()->user()->customer->phone_number }}" placeholder="Enter Customer's Phone Number">

                        @error('phone_number')
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
	            	<a href="{{url('/')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
                @else
                <form method="post" action="{{route('profile.update')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ auth()->user()->name }}" placeholder="Enter Customer Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control z-techno-el @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" placeholder="Enter Customer's Email">

                        @error('email')
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
                    <a href="{{url('/')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
                </form>
                @endif
        	</div>
        </div>
    </div>
</div>
@endsection
