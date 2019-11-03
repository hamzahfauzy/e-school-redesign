@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="content-wrapper">
            	<h2>Selamat Datang di e-School</h2>
            	<form method="post">
            		<div class="form-group">
            			<textarea class="form-control z-techno-el" rows="5" style="resize: none;" placeholder="Katakan sesuatu tentang hari ini.."></textarea>
            		</div>
            	</form>
            </div>
        </div>

        <div class="col-sm-md-3 col-sm-12">
        	
        </div>
    </div>
</div>
@endsection
