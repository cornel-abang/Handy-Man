@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>New {{$data->category}} Service Request</h1>
	Hi {{$data->user->name}}, thank you for requesting a service from Handiman. Your request has been recieved and a team will visit you on your requested visit date and time, for inspection and job evaluation.<br>
	You can always reschedule the visit through your dashboard before the due date.<br>
	Find details of your requested service below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	<tr>
		<th>Requested Service:</th>
		 <td>{{ $data->category }}</td>
		</tr>
		<hr>
	<tr>
		<th>Location:</th>
		<td>{{ $data->street_addr }}, {{$data->local_govt}}, {{$data->state}}</td>
	</tr>
	<hr>
	<tr>
		<th>Visiting Date:</th>
		<td>{!! $data->visiting_date !!}</td>
	</tr>
	<hr>
	<tr>                             
		<th>Requested By:</th>
		<td>{{ $data->user->name }}</td>
	</tr>
	<hr>	
</table>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop
{{-- ->format('l jS \\of F Y h:i:s A')
@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'black'])
<div style="margin: 0 auto;">
		<i class="fa fa-check-circle-o"></i>
	<button style="background-color: green; border: 1px solid green;">
		 <a href="{{route('accept_order', $data->invoice->service->id)}}" 
		 	style="font-weight: bold;text-decoration: none; color: white;">Accept</a> 
	</button>
	<button style="background-color: red; font-weight: bold; border: 1px solid red;">
		<i class="fa fa-times-circle-o"></i>
		<a href="{{route('decline_order', $data->invoice->service->id)}}" 
			style=" font-weight: bold; text-decoration: none; color: white;">Decline</a>
	</button>
</div>
@include('beautymail::templates.widgets.newfeatureEnd') --}}



