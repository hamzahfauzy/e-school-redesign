@extends('layouts.dashboard')
@section('teachers.exams.index','sidebar-active')
@section('site-title','- Kuis')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Kuis</h2>
	            <p>
	            	<a href="{{route('teachers.exams.create')}}" class="btn z-techno-btn z-techno-primary"><i class="fa fa-plus"></i> Tambah Kuis</a>
	            </p>
	            @if ($message = Session::get('success'))
			      <div class="alert alert-success alert-block">
			        <button type="button" class="close" data-dismiss="alert">×</button> 
			          <strong>{{ $message }}</strong>
			      </div>
			    @endif
	            <div class="table-responsive">
	            	<table class="table">
	            		@if(empty($exams) || count($exams) == 0)
	            		<tr>
	            			<td><i>Tidak ada data</i></td>
	            		</tr>
	            		@endif

	            		@foreach($exams as $key => $exam)
	            		<!-- Modal -->
	            		<tr>
	            			<td>
	            				{{++$key}} 
	            			</td>
	            			<td>
	            				@if($exam->start_at == null)
								<form onsubmit="return simpanPublish(this)">
								<input type="hidden" name="id" value="{{$exam->id}}">
	            				<div class="modal fade" id="exampleModal{{$exam->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content" style="border-radius: 0px;">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel">Publish</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								      	<div class="alert alert-danger alert-danger-{{$exam->id}}" style="display:none"></div>
								      	<div class="alert alert-success alert-success-{{$exam->id}}" style="display:none"></div>
								        <div>
								        	<div class="form-group">
								        		<label>Waktu Mulai</label>
								        		<input type="datetime-local" id="start_at" class="form-control z-techno-el" name="start_at">
								        	</div>
								        	<div class="form-group">
								        		<label>Waktu Selesai</label>
								        		<input type="datetime-local" id="finish_at" class="form-control z-techno-el" name="finish_at">
								        	</div>
								        </div>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn z-techno-btn btn-secondary" data-dismiss="modal">Tutup</button>
								        <button class="btn z-techno-btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
								      </div>
								    </div>
								  </div>
								</div>
								</form>
								@endif
	            				<span class="badge badge-success">{{$exam->type}}</span>
	            				@if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
	            				<span class="badge z-techno-primary">{{$exam->type}} akan dimulai pada {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}</span>
	            				@endif

	            				@if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)) && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
		                        <span class="badge badge-success">{{$exam->type}} sedang berlangsung</span>
		                        @endif

	            				@if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
	            				<span class="badge badge-primary">{{$exam->type}} Selesai</span>
	            				@endif
	            				<br>
	            				<a href="{{route('teachers.exams.items.index', $exam->id)}}"><b>{{$exam->name}}</b></a>
	            				<p>
	            					Mata Pelajaran : {{$exam->study->name}}<br>
	            					Kelas : {{$exam->classroom->name}}<br>
	            					Soal : {{$exam->questions()->count()}}<br>
	            					Pilihan Berganda : {{$exam->questions()->where('type','Pilihan Berganda')->count()}}<br>
	            					Essay : {{$exam->questions()->where('type','Essay')->count()}}
	            					@if($exam->start_at != null)
	            					<br>
	            					Mulai : {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)}}<br>
	            					Selesai : {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)}}

	            					@endif
	            				</p>
	            				<form method="POST" action="{{route('teachers.exams.delete')}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
								    <input type="hidden" name="id" value="{{$exam->id}}">
								    @if($exam->start_at == null)
		            				<a href="javascript:void(0)" class="btn z-techno-btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$exam->id}}"><i class="fa fa-rocket"></i> Publish</a>
		            				@else
		            					@if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
		            				<a href="{{route('teachers.exams.show',$exam->id)}}" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Siswa</a>
		            					@endif
		            					@if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->finish_at)))
		            				<!-- <a href="javascript:void(0)" class="btn z-techno-btn btn-primary"><i class="fa fa-eye"></i> Lihat Hasil</a> -->
		            					@else
		            				<a href="javascript:void(0)" class="btn z-techno-btn btn-primary"><i class="fa fa-check"></i> Sudah di Publish</a>
		            					@endif
		            				@endif
		            				<a href="{{route('teachers.exams.items.index', $exam->id)}}" class="btn z-techno-btn btn-success"><i class="fa fa-eye"></i> Soal</a>
		            				@if($exam->start_at != null && \Carbon\Carbon::now()->lt(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $exam->start_at)))
		            				<a href="{{route('teachers.exams.edit', $exam->id)}}" class="btn z-techno-btn z-techno-secondary"><i class="fa fa-pencil"></i> Edit</a>
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn z-techno-btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
		            				@endif
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$exams->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
function simpanPublish(el)
{
	var start_at = $(el).find('input[name="start_at"]').val()
	var id = $(el).find('input[name="id"]').val()
	var finish_at = $(el).find('input[name="finish_at"]').val()
	let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	fetch("{{route('teachers.exams.publish')}}",{
		headers: {
			"Content-Type": "application/json",
		    "Accept": "application/json, text-plain, */*",
		    "X-Requested-With": "XMLHttpRequest",
		    "X-CSRF-TOKEN": token
		},
		method: 'POST',
		body: JSON.stringify({
		    id: id,
		    start_at: start_at,
		    finish_at: finish_at
		})
	})
	.then(res => res.json())
	.then(res => {
		if(res.errors != undefined)
		{
			ulElement = document.createElement('ul');
			ulElement.style.margin = '0px'
			ulElement = $(ulElement)
			$('.alert-danger.alert-danger-'+id).empty()
			res.errors.forEach(val => {
				ulElement.append('<li>'+val+'</li>')
			})
			$('.alert-danger.alert-danger-'+id).append(ulElement);
		}
		else
		{
			$('.alert-danger.alert-danger-'+id).hide()
			$('.alert-success.alert-success-'+id).show()
			$('.alert-success.alert-success-'+id).append(res.success)
			setTimeout(() => {
				location=location
			},1500)
		}

	});

	return false;

}
</script>
@endsection