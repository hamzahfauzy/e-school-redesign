@extends('layouts.dashboard')
@section('teachers.questions.index','sidebar-active')
@section('site-title','- Edit Kuis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-wrapper">
                <h2>Edit Kuis</h2>

                <form method="post" action="{{route('teachers.exams.update')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$exam->id}}">
                    <div class="form-group">
                        <label>Mata Pelajaran dan Kelas</label>
                        <select name="study" class="form-control z-techno-el @error('study') is-invalid @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($studies as $study)
                            <option value="{{$study->pivot->id}}" {{$exam->study_id == $study->pivot->study_id && $exam->classroom_id == $study->pivot->classroom_id ? 'selected' : ''}}>{{$study->pivot->study->name}} - {{$study->pivot->classroom->name}}</option>
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
                        <input type="text" class="form-control z-techno-el @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $exam->name }}" placeholder="Masukkan Judul Kuis">

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
                            <option value="{{$value}}" {{$exam->type == $value ? 'selected' : ''}}>{{$value}}</option>
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
                        <input name="start_at" value="{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$exam->start_at)->format('Y-m-d\TH:i:s')}}" class="form-control z-techno-el @error('start_at') is-invalid @enderror" type="datetime-local">

                        @error('start_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Selesai</label>
                        <input name="finish_at" value="{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$exam->finish_at)->format('Y-m-d\TH:i:s')}}" class="form-control z-techno-el @error('finish_at') is-invalid @enderror" type="datetime-local">

                        @error('finish_at')
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
