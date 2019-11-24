@extends('layouts.dashboard')
@section('teachers.questions.index','sidebar-active')
@section('site-title','- Tambah Jawaban Soal '.$question->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Tambah Jawaban Soal {{$question->title}}</h2>

	            <form method="post" action="{{route('teachers.questions.answer.store')}}">
	            	{{csrf_field()}}
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <div class="form-group">
                        <label>Soal</label>
                        <p>{{$question->description}}</p>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control z-techno-el @error('description') is-invalid @enderror" name="description" placeholder="Masukkan Deskripsi Soal" rows="6" style="resize: none;">{{ old('description') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
	            	<button class="btn z-techno-btn z-techno-primary">Submit</button>
	            	<a href="{{route('teachers.questions.show',$question->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
	            </form>
	        </div>
        </div>
    </div>
</div>
@endsection
