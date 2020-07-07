@extends('layouts.dashboard')
@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><i class="la la-money"></i> Invoice for {{$invoice->service->category}}</div>

                    <div class="card-body">
                        
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
                                  <th scope="row">=></th>
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
                              <small>
                                @if($invoice->status === 'Paid')
                                  <span class="badge badge-pill badge-success fa fa-check-circle"> 
                                    Paid
                                  </span>
                                @elseif($invoice->status === 'Percentage')
                                <span class="badge badge-pill badge-success"> 
                                    30% Due: (&#8358;{!!number_format(($invoice->sum_total * 30)/100)!!}
                                </span>
                                @else
                                  <span class="badge badge-pill badge-success"> 
                                    70% Due: (&#8358;{!!number_format(($invoice->sum_total * 70)/100)!!}
                                  </span>
                                  @endif
                              </small>
                            </h3>
                            <strong></strong>
                          </div>
                      </div>
                      <div class="modal-footer">

                        @if($invoice->status === 'Paid')
                        
                        @else
                        <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" role="form">
                          @csrf
                          <input type="hidden" name="email" value="{{$invoice->service->user->email}}"> {{-- required --}}
                            @if($invoice->status === 'Unpaid')
                                {{-- Get only 70% of the total amount for first time payment --}}
                              <input type="hidden" name="amount" value="{!! (($invoice->sum_total * 70)/100) * 100 !!}">
                              <input type="hidden" name="metadata" value="{{ json_encode($array = [
                              'invoice_id' => $invoice->id,
                              'payment_status' => 'Percentage',
                              'client_name' => $invoice->service->user->name
                              ]) }}" > 
                              {{-- in kobo --}}
                            @else
                              <input type="hidden" name="amount" value="{!! (($invoice->sum_total * 30)/100) * 100 !!}">
                              <input type="hidden" name="metadata" value="{{ json_encode($array = [
                              'invoice_id' => $invoice->id,
                              'payment_status' => 'Complete'
                              ]) }}" >
                               {{-- in kobo --}}
                            @endif
                          <input type="hidden" name="currency" value="NGN">
                          <input type="hidden" name="first_name" value="">
                          <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                          @if($invoice->status === 'Percentage')
                          <button type="submit" class="btn btn-secondary">
                            <span class="fa fa-money-bill-alt"></span> {!! $invoice->status === 'Unpaid' ? 'Pay Now!': 'Complete Payment' !!}
                          </button>
                          @else
                          <button type="submit" class="btn btn-secondary">
                            <span class="fa fa-money-bill-alt"></span> Pay Now!
                          </button>
                        </form>
                        @endif
                        
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-warning" onclick="window.location.href='{{route('flag_job', $invoice->service->id)}}'">Flag</button>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection