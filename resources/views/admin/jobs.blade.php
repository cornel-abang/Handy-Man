@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($jobs->count())
                <table class="table table-bordered">

                    <tr>
                        <th><span class="fa fa-hard-hat ic"></span> Job category</th>
                        <th><span class="fa fa-file-invoice-dollar ic"></span> Invoice</th>
                        <th><span class="fa fa-hash ic"></span> #</th> 
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
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#invoice{{$job->id}}"><i class="la la-eye"></i> View</button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Flag invoice"><i class="la la-flag"></i> Flag</a>
                                    </div>
                                </div>

                                <!--<a href="" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="@lang('app.view')"><i class="la la-eye"></i> </a>
                                <a href="" class="btn btn-secondary btn-sm"><i class="la la-edit" data-toggle="tooltip" title="@lang('app.edit')"></i> </a>

                                
                                    <a href="{{route('job_status_change', [$job->id, 'premium'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.mark_premium')"><i class="la la-bookmark-o"></i> </a>
                               

                                
                                        <a href="{{route('job_status_change', [$job->id, 'approve'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="la la-check-circle-o"></i> </a>
                                   

                                    
                                        <a href="{{route('job_status_change', [$job->id, 'block'])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="la la-ban"></i> </a>
                                    

                                    <a href="{{route('job_status_change', [$job->id, 'delete'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.delete')"><i class="la la-trash-o"></i> </a>-->
                                


                            </td>
                            <td> 
                               <div class="col-md-6">
                                        <a href="" class="btn btn-info btn-sm" data-toggle="modal" data-target="#job{{$job->id}}"><i class="la la-star"></i> Mark Off</a>
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
                            <h3 class="pull-right">Sum Total: &#8358;{!! number_format($job->invoice->sum_total) !!}</h3>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary">
                          <span class="fa fa-money-bill-alt"></span> Make Payment
                        </button>
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-warning" onclick="window.location.href='{{route('flag-invoice', 
                        $job->invoice->id)}}'">Flag</button>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endforeach


@endsection