@extends('layouts.dashboard')
@section('sistem-informasi.classrooms.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Edit Pelajaran Kelas {{$classroom->name}}</h2>

	            <form method="post" action="{{route('sistem-informasi.classrooms.studies.update',[$classroom->id,$classroomStudy->pivot->study_id])}}">
	            	{{csrf_field()}}
                    <input type="hidden" name="classroom_id" value="{{$classroom->id}}">

                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select class="form-control z-techno-el @error('study') is-invalid @enderror" name="study">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($studies as $study)
                                <option value="{{ $study->id }}" {{$classroomStudy->pivot->study_id == $study->id ? 'selected' : ''}}>{{ $study->name }}</option>
                            @endforeach
                        </select>
                        @error('study')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Guru Pengampuh</label>
                        <select class="form-control z-techno-el @error('teacher') is-invalid @enderror" name="teacher">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{$classroomStudy->pivot->user_id == $teacher->id ? 'selected' : ''}}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        @error('teacher')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('sistem-informasi.classrooms.show-studies',$classroom->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
