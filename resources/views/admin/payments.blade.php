@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($payments->count() > 0)
                <p><b>{{$payments->total()}}</b> Payment detail(s) found on the system</p>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Payer Name</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <td>View Details</td>
                    </tr>

                    @foreach($payments as $Payment)
                        <tr>
                            <td>
                                {{ $payment->payer_name }}
                            </td>
                            <td>&#8358;{!! number_format($payment->amount) !!}</td>
                            <td>
                                {!! $payment->created_at->format(get_option('date_format')) !!}
                            </td>
                            <td>
                                <a href="" class="btn btn-secondary btn-sm" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#payment{{$payment->reference}}">
                                    <i class="la la-eye"></i> 
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                {!! $payments->links() !!}

            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="no data-wrap py-5 my-5 text-center">
                            <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                            <h1>No Data available here</h1>
                        </div>
                    </div>
                </div>
            @endif



        </div>
    </div>
    
@foreach($payments as $payment)
<!-- Modal -->
<div class="modal fade" id="payment{{$payment->reference}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-hard-hat"></span> Payment {{$payment->reference}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Payer Name</th>
                                <td>{{ $payment->payer_name }}</td>
                            </tr>
                            <tr>
                                <th>Amount Paid</th>
                                <td>&#8358;{!! number_format($payment->amount) !!}</td>
                            </tr>

                            <tr>
                                <th>Payment Reference</th>
                                <td>{{ $payment->reference }}</td>
                            </tr>
                            <tr>
                                <th>Paid For</th>
                                <td>{{ $payment->invoice->category }}</td>
                            </tr>
                            <tr>
                                <th>Channel</th>
                                <td>{{ $payment->channel }}</td>
                            </tr>
                            <tr>
                                <th>Payer Bank</th>
                                <td>{{ $payment->payer_bank }}</td>
                            </tr>
                            <tr>
                                <th>Card Type</th>
                                <td>{{ $payment->card_type }}</td>
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td>
                                {!! $payment->created_at->format(get_option('date_format')) !!}
                                </td>
                            </tr>
                        </table>
      </div>
    </div>
  </div>
</div>
@endforeach


@endsection