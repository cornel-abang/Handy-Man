@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($jobs->count())
                <table class="table table-bordered" id="{{$state}}">

                    <tr>
                        <th><span class="fa fa-hard-hat ic"></span> Job category</th>
                        <th><span class="fa fa-map-marker ic"></span> Location</th>
                        <th><span class="fa fa-file-invoice-dollar ic"></span> Invoice</th>
                        <th><span class="fa fa-hashtag"></span>Mark</th>
                        <th><span class="fa fa-calendar-alt ic"></span> Visiting Date</th>
                        <th><span class="fa fa-hard-hat"></span> Artisan</th>
                    </tr>

                    @foreach($jobs as $job)
                        <tr class="mark" id="job{{$job->id}}">
                            <td>{{$job->category}}
                                

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
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-target="#invoice{{$job->id}}" title="View invoice"><i class="la la-eye"></i></button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit invoice"><i class="la la-edit"></i></a>
                                    </div>
                                </div>
                              </td>

                                <td>
                                  <div class="row">
                                    <div class="col-md-3">
                                      @if($job->status === "In-Progress")
                                      <a href="" class="btn btn-info btn-info-mark btn-sm mark in-progress marked" 
                                      id="{{$job->id}}" data-toggle="tooltip" title="Mark as IN PROGRESS"><i class="la la-bookmark-o"></i> </a>
                                      @else
                                      <a href="" class="btn btn-info btn-info-mark btn-sm mark in-progress" id="{{$job->id}}" data-toggle="tooltip" title="Mark as in IN PROGRESS"><i class="la la-bookmark-o"></i> 
                                      </a>
                                      @endif    
                                    </div>

                                    <div class="col-md-3">
                                      @if($job->status === "Completed")
                                       <a href="" class="btn btn-success btn-sm mark completed marked" id="{{$job->id}}" 
                                        data-toggle="tooltip" title="Mark as COMPLETED"><i class="la la-check-circle-o"></i>
                                       </a>
                                       @else
                                       <a href="" class="btn btn-success btn-sm mark completed" id="{{$job->id}}" 
                                        data-toggle="tooltip" title="Mark as COMPLETED"><i class="la la-check-circle-o"></i>
                                        </a>
                                       @endif
                                    </div>

                                    <div class="col-md-3">
                                      @if($job->status === "Pending")
                                       <a href="" class="btn btn-warning btn-sm mark pending marked" id="{{$job->id}}" 
                                        data-toggle="tooltip" title="Mark as PENDING"><i class="la la-ban"></i> </a>
                                        @else
                                        <a href="" class="btn btn-warning btn-sm mark pending" id="{{$job->id}}" 
                                          data-toggle="tooltip" title="Mark as PENDING"><i class="la la-check-circle-o"></i> 
                                        </a>
                                        @endif
                                    </div>                                    
                                    
                                    <div class="col-md-3">
                                      @if($job->status === "Cancelled")
                                      <a href="" class="btn btn-danger btn-sm mark cancelled marked" id="{{$job->id}}"
                                       data-toggle="tooltip" title="Mark as CANCELLED"><i class="la la-times-circle-o"></i> 
                                      </a>
                                      @else
                                      <a href="" class="btn btn-danger btn-sm mark cancelled" id="{{$job->id}}" 
                                        data-toggle="tooltip" title="Mark as CANCELLED"><i class="la la-check-circle-o"></i> 
                                      </a>
                                      @endif
                                    </div>

                                  </div>
                            </td>
                            <td>
                                {{-- {{$job->visiting_date->format(get_option('date_format'))}} --}}
                                {{ $job->visiting_date }}
                                <p class="job-status" data-toggle="tooltip" title="Job {{$job->status}}">
                                  <i class="la la-tag"></i>
                                  <span id="jab{{$job->id}}" class="{{$job->status}}">{{$job->status}}</span>
                                </p> 
                            </td>
                            <td>
                              @if(!empty($job->artisan->full_name))
                                <a href="{{route('view_artisan', $job->artisan->id)}}">
                                  <span class="badge badge-pill badge-success fa fa-hard-hat"> 
                                    {{ $job->artisan->full_name}}
                                  </span>
                                </a>
                              @else
                              <div id="assign_handle">
                                <span id="artisan_assigned{{$job->id}}" class="badge badge-pill badge-success"></span>
                                <form class="form-inline">
                                @csrf
                                <select name="artisan" id="assigned{{$job->id}}">
                                  <option value="">--Assign--</option>
                                  @php
                                  // $slug = \App\Http\Controllers\ArtisanController::createSlug($job->category);
                                  $artisans = \App\Http\Controllers\ArtisanController::getArtisans($job->category);
                                  @endphp
                                  @foreach($artisans as $artisan){
                                  <option value="{{$artisan->id}}">{{$artisan->full_name}}</option>
                                  @endforeach
                                </select>
                                <button type="submit" id="{{$job->id}}" class="btn btn-primary fa fa-arrow-alt-circle-right assign" style="margin-top: 3px;"></button>
                              </form>
                            </div>
                            @endif
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