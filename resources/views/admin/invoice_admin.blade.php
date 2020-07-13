@extends('layouts.dashboard')
@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><i class="la la-money"></i> 
                      Invoice for {{$invoice->service->category}} 

                    </div>

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
                                <span class="badge badge-pill badge-info"> 
                                   70% Paid - 30% Due: (&#8358;{!!number_format(($invoice->sum_total * 30)/100)!!})
                                </span>
                                @else
                                  <span class="badge badge-pill badge-warning"> 
                                    Unpiad - 70% Due: (&#8358;{!!number_format(($invoice->sum_total * 70)/100)!!}
                                  </span>
                                  @endif
                              </small>
                            </h3>
                            <strong></strong>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-success fa fa-edit" onclick="window.location.href='{{route('edit-invoice', $invoice->id)}}'"> Edit</button>
                        
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