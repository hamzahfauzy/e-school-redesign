@extends('layouts.dashboard')
@section('local-storage.index','sidebar-active')
@section('site-title','- Penyimpanan Pribadi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content-wrapper">
                <h2>Penyimpanan Pribadi</h2>
                <p>
                    <a href="{{route('sistem-informasi.classrooms.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-cloud-upload"></i> Upload File</a>
                    <a href="{{route('sistem-informasi.classrooms.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Buat Folder Baru</a>
                </p>
                @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                  </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Uploaded At</th>
                        </tr>
                        <tr>
                            <td colspan="3"><i>Data not found!</i></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
