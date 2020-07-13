@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($jobs->count())
                <table class="table table-bordered">

                    <tr>
                        <th><span class="fa fa-hard-hat ic"></span> Job category</th>
                        <th><span class="fa fa-file-invoice-dollar ic"></span> Invoice</th>
                        <th># </th>
                        <th><span class="fa fa-star ic"></span> </th>  
                    </tr>

                    @foreach($jobs as $job)
                        <tr>
                            <td>{{$job->category}}
                              @if($job->status === 'Completed')
                               <span class="badge badge-pill badge-success">Completed</span>
                              @endif 
  
                            </td>
                            
                            {{-- <td>{{$job->street_addr}},  
                                @php
                                    echo str_replace('-', ' ', $job->local_govt);
                                @endphp
                                ,
                                @php 
                                    echo str_replace('_', ' ', $job->state);
                                @endphp
                            </td>--}}
                            <td>
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                       @if($job->invoice !== null)
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#invoice{{$job->id}}"><i class="la la-eye"></i> View</button>
                                        @else
                                        <span><i class="la la-eye-slash"></i></span>
                                        @endif
                                    </div>
                                    
                                </div>

                                <td>
                                  <div class="col-md-6">
                                      @if($job->invoice !== null)
                                        <a class="btn btn-warning btn-sm" onclick="window.location.href='{{route('flag_job', $job->id)}}'"><i class="la la-flag"></i> Flag</a>
                                        @else
                                        <span><i class="la la-times-circle-o"></i></span>
                                        @endif
                                    </div>
                                </td>

                            </td>
                            <td> 
                               <div class="col-md-6">
                                      @if($job->invoice !== null)
                                        <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#job{{$job->id}}"><i class="la la-star"></i> Mark Off</a>
                                      @else
                                        <span><i class="la la-times-circle"></i></span>
                                      @endif
                                  </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                

                <!--Invoice Modal Begins-->
                <!-- Modal -->
                @foreach($jobs as $job)
                @if($job->invoice !== null)
                <div class="modal fade" id="invoice{{$job->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div class="modal-title">
                          <h3 class="" id="{{$job->id}}">Job Invoice: <br></h3>
                          <strong>For:</strong> {{$job->category}} <br>
                          <strong>To:</strong> {!!$job->user['name']!!}
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">
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
                              
                                @foreach($job->invoice->items as $item)
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
                              Sum Total: &#8358;{!! number_format($job->invoice->sum_total) !!}
                              <small>
                                @if($job->invoice->status === 'Paid')
                                  <span class="badge badge-pill badge-success fa fa-check-circle"> 
                                    Paid
                                  </span>
                                @elseif($job->invoice->status === 'Percentage')
                                <span class="badge badge-pill badge-success"> 
                                    30% Due: (&#8358;{!!number_format(($job->invoice->sum_total * 30)/100)!!}
                                </span>
                                @else
                                  <span class="badge badge-pill badge-success"> 
                                    70% Due: (&#8358;{!!number_format(($job->invoice->sum_total * 70)/100)!!}
                                  </span>
                                  @endif
                                {{-- {!! $job->invoice->status === 'Unpaid' ? '<span class="badge badge-pill badge-success"> 70% Due: (&#8358;'.number_format(($job->invoice->sum_total * 70)/100).')</span>' : '<span class="badge badge-pill badge-success"> 30% Due: (&#8358;'.number_format(($job->invoice->sum_total * 30)/100).')</span>' !!} --}}
                              </small>
                            </h3>
                            <strong></strong>
                          </div>
                      </div>
                      <div class="modal-footer">

                        @if($job->invoice->status === 'Paid')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        @else
                        <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" role="form">
                          @csrf
                          <input type="hidden" name="email" value="{{$job->user->email}}"> {{-- required --}}
                            @if($job->invoice->status === 'Unpaid')
                                {{-- Get only 70% of the total amount for first time payment --}}
                              <input type="hidden" name="amount" value="{!! (($job->invoice->sum_total * 70)/100) * 100 !!}">
                              <input type="hidden" name="metadata" value="{{ json_encode($array = [
                              'invoice_id' => $job->invoice->id,
                              'payment_status' => 'Percentage',
                              'client_name' => $job->user->name
                              ]) }}" > 
                              {{-- in kobo --}}
                            @else
                              <input type="hidden" name="amount" value="{!! (($job->invoice->sum_total * 30)/100) * 100 !!}">
                              <input type="hidden" name="metadata" value="{{ json_encode($array = [
                              'invoice_id' => $job->invoice->id,
                              'payment_status' => 'Complete'
                              ]) }}" >
                               {{-- in kobo --}}
                            @endif
                          <input type="hidden" name="currency" value="NGN">
                          <input type="hidden" name="first_name" value="">
                          <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                          @if($job->invoice->status === 'Percentage')
                          <button type="submit" class="btn btn-secondary">
                            <span class="fa fa-money-bill-alt"></span> {!! $job->invoice->status === 'Unpaid' ? 'Pay Now!': 'Complete Payment' !!}
                          </button>
                          @else
                          <button type="submit" class="btn btn-secondary">
                            <span class="fa fa-money-bill-alt"></span> Pay Now!
                          </button>
                        </form>
                        @endif
                        
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-warning" onclick="window.location.href='{{route('flag_job', $job->id)}}'">Flag</button>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                @endforeach
                <!--Invoice Modal ends-->

                {!! $jobs->links() !!}
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

@foreach($jobs as $job)
<!-- Modal -->
<div class="modal fade" id="job{{$job->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mark off job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('mark-job')}}" method="post" class="form{{$job->id}}">
          @csrf
          <label for="recipient-name" class="col-form-label"><b>How would you rate the servcie?</b></label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="rating" id="exampleRadios1" value="Poor" checked>
            <label class="form-check-label" for="exampleRadios1">
              Poor
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="rating" id="exampleRadios2" value="Good">
            <label class="form-check-label" for="exampleRadios2">
              Good
            </label>
          </div>
          <div class="form-check disabled">
            <input class="form-check-input" type="radio" name="rating" id="exampleRadios3" value="very-good" >
            <label class="form-check-label" for="exampleRadios3">
              Very Good
            </label>
          </div>
          <div class="form-check disabled">
            <input class="form-check-input" type="radio" name="rating" id="exampleRadios3" value="Excellent" >
            <label class="form-check-label" for="exampleRadios3">
              Excellent
            </label>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1"><b>Comments:</b></label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
          </div>
          <input type="hidden" name="service_id" value="{{$job->id}}">
          <button type="submit" class="btn btn-primary mark-btn" id="{{$job->id}}">Mark off</button>
        </form>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> --}}
    </div>
  </div>
</div>
@endforeach


@endsection