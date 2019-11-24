@extends('layouts.dashboard')
@section('teachers.exams.index','sidebar-active')
@section('site-title','- Tambah Soal Kuis '.$exam->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-wrapper">
                <h2>Tambah Soal Kuis {{$exam->name}}</h2>
                <p>
                    <a href="{{route('teachers.exams.items.index',$exam->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        @if(empty($questions) || count($questions) == 0)
                        <tr>
                            <td><i>Tidak ada data</i></td>
                        </tr>
                        @endif

                        @foreach($questions as $key => $question)
                        <tr>
                            <td>
                                {{++$key}} 
                            </td>
                            <td>
                                <span class="badge badge-success">{{$question->type}}</span><br>
                                <a href="{{route('teachers.questions.show', $question->id)}}"><b>{{$question->title}}</b></a>
                                <p>{{nl2br($question->description)}}</p>
                                <form method="POST" action="{{route('teachers.exams.items.store',$exam->id)}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$question->id}}">
                                    <button class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambahkan Ke Kuis</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{$questions->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
