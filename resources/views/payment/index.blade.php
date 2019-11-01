@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        	<div class="content-wrapper">
	            <h2>Payments</h2>
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
	            			<th>Customer Name</th>
	            			<th>E-Mail</th>
	            			<th>Proof</th>
	            			<th>Amount</th>
	            			<th>Status</th>
	            			<th></th>
	            		</tr>
	            		@if(empty($payments) || count($payments) == 0)
	            		<tr>
	            			<td colspan="3"><i>Data not found!</i></td>
	            		</tr>
	            		@endif

	            		@foreach($payments as $key => $payment)
	            		<tr>
	            			<td align="center">{{++$key}}</td>
	            			<td>{{$payment->customer['name']}}</td>
	            			<td>{{$payment->customer['email']}}</td>
	            			<td>
	            				<img src="{{asset('upload/payments/'.$payment->proof_picture)}}" width="70" data-toggle="modal" data-target="#myModal{{$payment->id}}"	style="cursor: pointer;">
	            			</td>
	            			<td>@rupiah($payment->amount)</td>
	            			<td>
								<div class="dropdown">
								  <button class="btn 
									@if($payment->status==0)
										btn-warning
								  	@elseif($payment->status==1)
								  		btn-third
								  	@elseif($payment->status==2)
								  		btn-secondary
									@endif

								   dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  	@if($payment->status==0)
										Pending
								  	@elseif($payment->status==1)
										Accept
								  	@elseif($payment->status==2)
								  		Declined
									@endif
								  </button>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								    <a class="dropdown-item" href="{{route('payment.pending', $payment->id) }}">@if($payment->status==0) <i class="fa fa-check"></i> @endif Pending</a>
								    <a class="dropdown-item" href="{{route('payment.accept', $payment->id) }}">@if($payment->status==1) <i class="fa fa-check"></i> @endif Accept</a>
								    <a class="dropdown-item" href="{{route('payment.decline', $payment->id)}}">@if($payment->status==2) <i class="fa fa-check"></i> @endif Decline</a>
								</div>
  	            				</td>
	            			<td>
	            				<form method="POST" action="{{route('payment.delete', $payment->id)}}">
								    {{ csrf_field() }}
								    {{ method_field('DELETE') }}
		            				<!-- <a href="" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a> -->
								    <button onclick="if(!confirm('Are you sure to delete?')){ return false; }" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
								</form>
	            			</td>
	            		</tr>
	            		@endforeach
	            	</table>
	            	{{$payments->links()}}
	            </div>
	        </div>
        </div>
    </div>
</div>
					<!-- PROOF MODAL -->
					@foreach($payments as $key => $payment)
					<!-- Modal -->
					<div id="myModal{{ $payment->id }}" class="modal fade" role="dialog">
					  <div class="modal-dialog modal-lg">

					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <h4 class="modal-title">{{ $payment->customer['name'] }}</h4>
					      </div>
					      <div class="modal-body">
					        <p><img src="{{asset('upload/payments/'.$payment->proof_picture)}}" width="100%"></p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>

					  </div>
					</div>
					@endforeach


@endsection
