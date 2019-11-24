@extends('layouts.dashboard')
@section('teachers.exams.index','sidebar-active')
@section('site-title','- Tambah Kuis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Tambah Kuis</h2>

	            <form method="post" action="{{route('teachers.exams.store')}}">
	            	{{csrf_field()}}
                    <div class="form-group">
                        <label>Mata Pelajaran dan Kelas</label>
                        <select name="study" class="form-control z-techno-el @error('study') is-invalid @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($studies as $study)
                            <option value="{{$study->pivot->id}}" {{old('study') == $study->pivot->id ? 'selected' : ''}}>{{$study->pivot->study->name}} - {{$study->pivot->classroom->name}}</option>
                            @endforeach
                        </select>

                        @error('study')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nama Kuis</label>
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Judul Kuis">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis Kuis</label>
                        <select name="type" class="form-control z-techno-el @error('type') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kuis --</option>
                            @foreach(['Latihan','Ulangan Harian','UTS','UAS'] as $value)
                            <option value="{{$value}}" {{old('type') == $value ? 'selected' : ''}}>{{$value}}</option>
                            @endforeach
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Mulai</label>
                        <input name="start_at" class="form-control z-techno-el @error('start_at') is-invalid @enderror" type="datetime-local">

                        @error('start_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Selesai</label>
                        <input name="finish_at" class="form-control z-techno-el @error('finish_at') is-invalid @enderror" type="datetime-local">

                        @error('finish_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('teachers.exams.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
