@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>New Invoice #{{$invoice->id}} for {{$invoice->service->category}} Job</h1>
	Dear {{$invoice->service->user->name}},<br>
	We are contacting you in regard to a new invoice #{{$invoice->id}} that has been created on your account. You may find details of the invoice attached below. Please endeavor to pay the due amount: <b>&#8358;{!! number_format(($invoice->sum_total*70)/100) !!}</b>, which is 70% of the invoice total of: <b>&#8358;{!! number_format($invoice->sum_total) !!}</b>, before the requested service can be started.
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Item Name</th>
            <th scope="col">Price/Unit (&#8358;)</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total (&#8358;)</th>
        </tr>
    </thead>
    <tbody>
     @foreach($invoice->items as $item)
        <tr>
        	<th scope="row">#</th>
                <td>{{$item->item_name}}</td>
                <td>{!! number_format($item->item_price) !!}</td>
                <td>{{$item->quantity}}</td>
                <td>{!! number_format($item->total) !!}</td>
        </tr>
    @endforeach
        <tr>
            <th colspan="3"></th>
        </tr>
    </tbody>
</table>
<h3 class="pull-right">
   Sum Total: &#8358;{!! number_format($invoice->sum_total) !!}
</h3>
You can carry out the payment by clicking the <b>Pay Now</b> button below.<br>
<div style="margin: 10px">
		<i class="fa fa-check-circle-o"></i>
	<button style="background-color: green; border: 1px solid green; border-radius: 1px;">
		 <a href="{{route('view_invoice', ['invoice_id'=>$invoice->id, 'user_id'=>$invoice->service->user->id])}}" 
		 	style="font-weight: bold;text-decoration: none; color: white;"><h1>Pay Now!</h1></a> 
	</button>
</div><br>
Please feel free to reply this email if you have any questions. <br><em>Cheers!</em>
                            
@include('beautymail::templates.widgets.newfeatureEnd')
@stop




