@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($invoices->count())
                <table class="table table-bordered" id="all-invoices">

                    <tr>
                        <th><span class="fa fa-user ic"></span> To</th>
                        <th><span class="fa fa-hard-hat ic"></span> Job</th>
                        <th><span class="fas fa-question-circle ic"></span> Status</th>
                        <th><span class="fa fa-hashtag ic"></span> Action</th>
                    </tr>

                    @foreach($invoices as $inv)
                        <tr>
                            <td>{{$inv->service->user->name}}
                                

                            </td>
                            <td>
                                
                                    <p><i class=""></i>{{$inv->service->category}}</p>
                              
                            </td>
                            <td>
                              <p class="alert alert-danger la la-bookmark-o" data-toggle="tooltip" title="Unpaid invoice">{{$inv->status}}</p> 
                            </td>
                            <td>
                                <div class="row">
                                   
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#invoice{{$inv->id}}"><i class="la la-eye"></i></button>
                                    </div>
                                    <div class="col-md-4" style="color: white;">
                                        <a href="{{route('edit-invoice', $inv->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit"><i class="la la-edit"></i> </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="javascript:void(0)" id="{{$inv->id}}" class="btn btn-danger btn-sm del_invoice_from_all" ><i class="la la-trash-o"></i> </a>
                                    </div>
                                </div>

                                <!--<a href="" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="@lang('app.view')"><i class="la la-eye"></i> </a>
                                <a href="" class="btn btn-secondary btn-sm"><i class="la la-edit" data-toggle="tooltip" title="@lang('app.edit')"></i> </a>

                                
                                    <a href="{{route('job_status_change', [$inv->id, 'premium'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.mark_premium')"><i class="la la-bookmark-o"></i> </a>
                               

                                
                                        <a href="{{route('job_status_change', [$inv->id, 'approve'])}}" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="la la-check-circle-o"></i> </a>
                                   

                                    
                                        <a href="{{route('job_status_change', [$inv->id, 'block'])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="la la-ban"></i> </a>
                                    

                                    <a href="{{route('job_status_change', [$inv->id, 'delete'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.delete')"><i class="la la-trash-o"></i> </a>-->
                                


                            </td>
                        </tr>
                    @endforeach
                </table>
                

                <!--Invoice Modal Begins-->
                <!-- Modal -->
                @foreach($invoices as $inv)
                <div class="modal fade" id="invoice{{$inv->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div class="modal-title">
                          <h3 class="" id="{{$inv->id}}">Job Invoice: <br></h3>
                          <strong>For:</strong> {{$inv->service->category}} <br>
                          <strong>To:</strong> {{$inv->service->user->name}}
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
                                @foreach($inv->items as $item)
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
                            <h3 class="pull-right">Sum Total: &#8358;{!! number_format($inv->sum_total) !!}</h3>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{route('edit-invoice', $inv->id)}}'">Edit</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                <!--Invoice Modal ends-->
              {{$invoices->links()}}
              
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="no data-wrap py-5 my-5 text-center">
                            <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                            <h1>No Data available here</h1>
                              <button type="button" class="btn btn-primary" style="background-color: #38c172; border: 1px solid #38c172;" onclick="window.location.href='{{route('new-invoice')}}'"><span class="fa fa-plus-circle"> Create new
                              </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>



@endsection