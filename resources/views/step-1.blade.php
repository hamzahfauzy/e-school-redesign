@extends('layouts.step')
@section('site-title','- Final Step')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="content-wrapper">
                <final-step id="{{auth()->user()->id}}"/>
            </div>
        </div>
    </div>
</div>
@endsection