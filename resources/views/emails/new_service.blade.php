@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>New {{$data->category}} Service Request</h1>
	Hi {{$data->user->name}},<br>Thank you for requesting a service from Handiman. Your request has been recieved and a team will visit you on the <b>{!! Carbon\Carbon::parse($data->visiting_date)->format('j F, Y') !!}</b> at time <b>{{ $data->visiting_time }}</b> as you requested, at your specified location <b>{{$data->location}}</b>, for inspection and job evaluation.<br>
	You can always reschedule the visit through your dashboard but only before the due date.<br>
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
		<td>{!! Carbon\Carbon::parse($data->visiting_date)->format('j F, Y') !!} at {{ $data->visiting_time }}</td>
	</tr>
	<hr>
	<tr>                             
		<th>Requested By:</th>
		<td>{{ $data->user->name }}</td>
	</tr>
	<hr>	
</table>
@include('beautymail::templates.widgets.newfeatureEnd')
@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'black'])
	<p>We hope to offer you the best maintenance service possible.<br>
		Regards,<br>
		Handiman Services
	</p>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop




