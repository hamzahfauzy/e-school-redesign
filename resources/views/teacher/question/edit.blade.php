@extends('layouts.dashboard')
@section('teachers.questions.index','sidebar-active')
@section('site-title','- Edit Soal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-wrapper">
                <h2>Edit Soal</h2>

                <form method="post" action="{{route('teachers.questions.update')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$question->id}}">
                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select name="study" class="form-control z-techno-el @error('study') is-invalid @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($studies as $study)
                            <option value="{{$study->pivot->study_id}}" {{$question->study_id == $study->pivot->study_id ? 'selected' : ''}}>{{$study->pivot->study->name}}</option>
                            @endforeach
                        </select>

                        @error('study')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control z-techno-el @error('title') is-invalid @enderror" name="title" value="{{ old('title') ? old('title') : $question->title }}" placeholder="Masukkan Judul Soal">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control z-techno-el @error('description') is-invalid @enderror" name="description" placeholder="Masukkan Deskripsi Soal" rows="6" style="resize: none;">{{ old('description') ? old('description') : $question->description }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis Soal</label>
                        <select name="type" class="form-control z-techno-el @error('type') is-invalid @enderror">
                            <option value="">-- Pilih Tipe Soal --</option>
                            <option value="Pilihan Berganda" {{$question->type == 'Pilihan Berganda' ? 'selected' : ''}}>Pilihan Berganda</option>
                            <option value="Essay" {{$question->type == 'Essay' ? 'selected' : ''}}>Essay</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button class="btn z-techno-btn z-techno-primary">Submit</button>
                    <a href="{{route('teachers.questions.index')}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
