@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($jobs->count())
                <table class="table table-bordered">

                    <tr>
                        <th><span class="fa fa-hard-hat ic"></span> Job category</th>
                        <th><span class="fa fa-calendar-alt ic"></span> Date</th>
                        <th><span class="fa fa-location-arrow ic"></span> Location</th>
                        <th><span class="fa fa-file-invoice-dollar ic"></span> Invoice</th>
                    </tr>

                    @foreach($jobs as $job)
                        <tr>
                            <td>{{$job->category}}
                                

                            </td>
                            <td>
                                {{$job->created_at->format(get_option('date_format'))}} 
                                
                                    <p class="alert alert-success" data-toggle="tooltip" title="{{$job->status}} job"><i class="la la-bookmark-o"></i>{{$job->status}}</p>
                              
                            </td>
                            <td>{{$job->street_addr}}, 
                                @php
                                    echo str_replace('-', ' ', $job->local_govt);
                                @endphp
                                ,
                                @php 
                                    echo str_replace('_', ' ', $job->state);
                                @endphp
                            </td>
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
                        </tr>
                    @endforeach
                </table>
                

                <!--Invoice Modal Begins-->
                <!-- Modal -->
                @foreach($jobs as $jab)
                <div class="modal fade" id="invoice{{$jab->id}}" tabindex="-1" role="dialog" aria-labelledby="{{$jab->category}}" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="{{$jab->id}}">Job Invoice: {{$jab->category}}</h5>
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
                                  <th scope="col">Quantity</th>
                                  <th scope="col">Price/Unit (&#8358;)</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">1</th>
                                  <td>Wire</td>
                                  <td>2 coils</td>
                                  <td>1,500</td>
                                </tr>
                                <tr>
                                  <th scope="row">2</th>
                                  <td>Iron Rods</td>
                                  <td>5 bars</td>
                                  <td>1,000</td>
                                </tr>
                                <tr>
                                  <th scope="row">3</th>
                                  <td>Drilling Machine (Rentage)</td>
                                  <td>1</td>
                                  <td>20,000</td>
                                </tr>
                                <tr colspan="3">
                                    <th>Sub Total</th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Make Payment</button>
                      </div>
                    </div>
                  </div>
                </div>
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



@endsection