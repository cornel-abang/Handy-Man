@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => '#ffbf00'])
<h1>Invoice Payment Confirmation: #{{$payment->invoice->id}}</h1>
	Hi {{$payment->invoice->service->user->name}}, we are pleased to inform you that your recent payment of 
	<b>&#8358;{!! number_format($payment->amount_paid) !!}</b> dated: <b>{{$payment->created_at->format('j F, Y')}}</b>, for invoice <b>#{{$payment->invoice->id}}</b> generated for your <b>{{$payment->invoice->service->category}}</b> job; has been recieved and approved.<br>
	Your invoice is represented as below:<br>
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
     @foreach($payment->invoice->items as $item)
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
   Sum Total: &#8358;{!! number_format($payment->invoice->sum_total) !!}<br>
   Amount Paid: &#8358;{!! number_format($payment->amount_paid) !!}<br>
   @if($payment->payment_status === 'Percentage')
   Balance: &#8358;{!! number_format(($payment->invoice->sum_total*30)/100) !!}<br>
</h3>
<h4>Please note that the invoice is considered <b>Paid</b> only when the the total amount is paid in full. You owe a balance of <b>&#8358;{!! number_format(($payment->invoice->sum_total*30)/100) !!}</b>, that is due at the end of the job.</h4>
@else
<h4>This invoice has been paid for in full and is now considered as <b>Paid</b>. Thank you!</h4>
@endif 
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'black'])
You can always keep up with the progress of your jobs by logging into your account dashbaord on our web app and navigate to jobs. If you have any questions or just want to chat, feel free to reply this email and we will be on hand in no time.<br>We are always here to offer you our top notch services, in the best way possible.
@include('beautymail::templates.widgets.newfeatureEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'black'])
Best Regards<br>
Handiman Services
@include('beautymail::templates.widgets.newfeatureEnd')
@stop

