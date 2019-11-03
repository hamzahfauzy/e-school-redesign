@extends('layouts.dashboard')
@section('sistem-informasi.classrooms.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Tambah Siswa Kelas {{$classroom->name}}</h2>
                @if ($message = Session::get('danger'))
                  <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif

	            <form method="post" action="{{route('sistem-informasi.classrooms.students.store')}}">
	            	{{csrf_field()}}
                    <input type="hidden" name="classroom_id" value="{{$classroom->id}}">
                    <div class="form-group">
                        <label>Siswa</label>
                        <select class="form-control z-techno-el @error('student') is-invalid @enderror" name="student">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{old('student') == $student->id ? 'selected' : ''}}>{{ $student->name }}</option>
                            @endforeach
                        </select>
                        @error('student')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('sistem-informasi.classrooms.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
