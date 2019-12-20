@extends('layouts.dashboard')
@section('teachers.studies.index','sidebar-active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Mata Pelajaran</h2>
	            <div class="table-responsive">
	            	<table class="table table-striped">
	            		<tr>
	            			<th>#</th>
	            			<th>Nama</th>
	            			<th>Kelas</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($studies) || count($studies) == 0)
	            		<tr>
	            			<td colspan="4"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($studies as $key => $study)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$study->name}}</td>
	            			<td>
	            				<b>{{$study->pivot->classroom->name}}</b>
	            			</td>
	            			<td>
		            			<a href="{{route('teachers.study.show', [$study->id,$study->pivot->classroom_id])}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-eye"></i> Lihat</a>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$studies->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection
