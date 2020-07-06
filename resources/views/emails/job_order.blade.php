@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>New Job Order - {{$data->invoice->service->category}}</h1>
	This is a Job Order for a <b>{{$data->invoice->service->category}}</b> job to be handled by you.
	Please find details of the Job attached below and commence immediately.
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	<tr>
		<th>Client Name</th>
		 <td>{{ $data->invoice->service->user->name }}</td>
		</tr>
		<hr>
	<tr>
		<th>Client Phone</th>
		<td>{{ $data->invoice->service->user->phone }}</td>
	</tr>
	<hr>
	<tr>
		<th>Client Email</th>
		<td>{{ $data->invoice->service->user->email }}</td>
	</tr>
	<hr>
	<tr>                             
		<th>Site Address</th>
		<td>{{ $data->invoice->service->street_addr }}</td>
	</tr>
	<hr>
	<tr>
		<th>Work Type</th>
		<td>{{ $data->invoice->service->category }}</td>
	</tr>
	<hr>
	<tr>
		<th>Description</th>
		<td>{{ $data->invoice->service->description }}</td>
	</tr>
	<hr>
	<tr>
		<th>Work Materials</th>
		<td>
		@foreach($data->invoice->items as $item)
		# {{$item->item_name}}({{$item->quantity}})<br>
		@endforeach
		</td>
	</tr>
	<hr>
	<tr>
		<th>Date Issued</th>
		<td>
		 {!! Carbon\Carbon::now()->format('j F, Y') !!}
		</td>
	</tr>
	<hr>
	<tr>
		<th>Artisan Assigned</th>
		<td>{{$data->invoice->service->artisan->full_name}}</td>
	</tr>
</table>
@include('beautymail::templates.widgets.newfeatureEnd')

{{-- @include('beautymail::templates.widgets.newfeatureStart', ['color'=>'black'])
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
@stop




{{-- @component('mail::button', ['url' => route('accept_order', $data->invoice->service->id)])
	Accept
@endcomponent
@component('mail::button', ['url' => route('decline_order', $data->invoice->service->id), 'color'=>'red'])
	Decline
@endcomponent --}}



