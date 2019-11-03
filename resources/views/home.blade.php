@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-9">
        	@if(auth()->user()->isRole('siswa'))
            <div class="content-wrapper">
            	<h2 style="font-size: 16px;">Selamat Datang di e-School</h2>
            	<form method="post" class="form-posts">
            		<div class="form-group posts-group">
            			<textarea class="form-control z-techno-el" rows="5" style="resize: none;" placeholder="Katakan sesuatu tentang hari ini.."></textarea>
            			<select class="form-control z-techno-el select2" name="post_for">
            				<option value="1">Semua Orang</option>
            				<option value="2">X TKJ 1</option>
            			</select>
            		</div>
            		<button class="btn z-techno-btn z-techno-primary">Bagikan</button>
            	</form>
            </div>
            @else
            <div class="content-wrapper">
            	<h2 style="font-size: 16px;">Selamat Datang di e-School</h2>
            	<form method="post" class="form-posts" enctype="multipart/form-data">
            		<div class="form-group posts-group">
            			<textarea class="form-control z-techno-el" rows="5" style="resize: none;" placeholder="Katakan sesuatu tentang hari ini.."></textarea>
            			<div class="z-techno-btn-group">
            				<button type="button" id="fileUploadPostBtn" onclick="fileUploadPost.click()" class="btn z-techno-btn z-techno-btn-float">File</button>
            				<button type="button" id="gambarUploadPostBtn" onclick="gambarUploadPost.click()" class="btn z-techno-btn z-techno-btn-float">Gambar</button>
            			</div>
            			<select class="form-control z-techno-el select2" name="post_for">
            				<option value="">Bagikan Ke...</option>
            				<option value="1">Semua Orang</option>
            				<option value="2">X TKJ 1</option>
            			</select>
            			<select class="form-control z-techno-el select2" name="post_for">
            				<option value="">Sebagai...</option>
            				<option value="1">Pengumuman</option>
            				<option value="2">Tugas</option>
            				<option value="3">Sesi Ujian</option>
            				<option value="4">Sesi Kelas Virtual</option>
            			</select>
            			<div style="display: none">
            				<input type="file" name="file" id="fileUploadPost" onchange="fileUploadPostBtn.innerHTML = '1 File Terpilih'">
            				<input type="file" name="gambar" id="gambarUploadPost" onchange="gambarUploadPostBtn.innerHTML = '1 Gambar Terpilih'">
            			</div>
            		</div>
            		<button class="btn z-techno-btn z-techno-primary">Bagikan</button>
            	</form>
            </div>
            @endif
            <br>

            {{'',$i=10}}
            @while($i)
            <div class="content-wrapper">
            	<div class="author-section">
            		<div class="author-picture">
            			@if(auth()->user()->customer && auth()->user()->customer->picture)
				    	<img src="{{asset('uploads/schools/'.auth()->user()->customer->school->id.'/'.auth()->user()->customer->picture)}}" width="100%">
				    	@elseif(auth()->user()->picture)
				    	<img src="{{asset('uploads/schools/'.auth()->user()->school[0]->id.'/'.auth()->user()->id.'/'.auth()->user()->picture)}}" width="100%">
				    	@else
				    	<img src="{{asset('assets/default.png')}}" width="100%">
				    	@endif
            		</div>
            		<div class="author-name">
            			<h4><a href="{{route('profile')}}">{{auth()->user()->name}}</a></h4>
            			<span class="badge badge-success">Pengumuman</span> <small>27 Agustus 2019 - 16:00 WIB</small>
            		</div>
            	</div>

            	<div class="post-section">
            		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            	</div>

            	<div class="post-meta">
            		<button class="btn z-techno-btn z-techno-primary">Jawab Tugas</button>
            		<button class="btn z-techno-btn z-techno-primary">Ikuti Kelas</button>
            		<button class="btn z-techno-btn z-techno-primary">Ikuti Ujian</button>
            	</div>
            </div>
            <br>
            <?php $i-- ?>
            @endwhile
        </div>

        <div class="col-lg-3 col-md-12">
        	
        </div>
    </div>
</div>
@endsection
