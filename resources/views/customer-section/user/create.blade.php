@extends('layouts.dashboard')
@section('sistem-informasi.users.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Tambah Pengguna</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('sistem-informasi.users.store')}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control z-techno-el @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


	            	<div class="form-group">
	            		<label>Password</label>
	            		<input type="password" class="form-control z-techno-el @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Masukkan Password">

                        @error('password')
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
