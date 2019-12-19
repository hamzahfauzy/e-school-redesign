@extends('layouts.dashboard')
@section('sistem-informasi.schools.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-sm-12">
        	<div class="content-wrapper">
	            <h2>Data Sekolah</h2>
                @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('sistem-informasi.schools.update')}}">
	            	{{csrf_field()}}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label>ID Sekolah / NPSN</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="school_id" value="{{ old('school_id') ? old('school_id') : $school->school_id }}" placeholder="Masukkan Nama Sekolah">

                        @error('school_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $school->name }}" placeholder="Masukkan Nama Sekolah">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control z-techno-el @error('address') is-invalid @enderror" placeholder="Masukkan Alamat Sekolah">{{ old('address') ? old('address') : $school->address }}</textarea>

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="tel" class="form-control z-techno-el @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : $school->phone_number }}" placeholder="Enter Customer's Phone Number">

                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kepala Sekolah</label>
                        <input type="text" class="form-control z-techno-el @error('headmaster_name') is-invalid @enderror" name="headmaster_name" value="{{ old('headmaster_name') ? old('headmaster_name') : $school->headmaster_name }}" placeholder="Masukkan Nama Sekolah">

                        @error('headmaster_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>ID / NIP / NUPTK</label>
                        <input type="text" class="form-control z-techno-el @error('headmaster_employee_id') is-invalid @enderror" name="headmaster_employee_id" value="{{ old('headmaster_employee_id') ? old('headmaster_employee_id') : $school->headmaster_employee_id }}" placeholder="Masukkan Nama Sekolah">

                        @error('headmaster_employee_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            </form>
	        </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="content-wrapper">
                <h2>Foto Sekolah</h2>
                @if ($message = Session::get('upload_success'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif
                <form method="post" id="formUploadSchoolPicture" action="{{route('sistem-informasi.schools.upload')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        @if(auth()->user()->customer->school->picture)
                        <button type="button" class="btn z-techno-btn z-techno-primary" onclick="picture.click()" style="position: absolute;"><i class="fa fa-pencil"></i></button>
                        <img src="{{asset('uploads/schools/'.auth()->user()->customer->school->id.'/'.auth()->user()->customer->school->picture)}}" width="100%">
                        @else
                        <br>
                        <button type="button" class="btn z-techno-btn z-techno-primary" onclick="picture.click()">Upload</button>
                        @endif
                        <input type="file" onchange="formUploadSchoolPicture.submit()" id="picture" class="form-control z-techno-el @error('picture') is-invalid @enderror" name="picture" style="display: none;">

                        @error('picture')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- <button class="btn z-techno-btn z-techno-primary">Submit</button> -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
