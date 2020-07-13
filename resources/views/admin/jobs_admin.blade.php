@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($jobs->count())
                <table class="table table-bordered" id="{{$state}}">

                    <tr>
                        <th><span class="fa fa-hard-hat ic"></span> Job category</th>
                        <th><span class="fa fa-hard-hat ic"></span> Artisan</th>
                        <th><span class="fa fa-file-invoice-dollar ic"></span> Invoice</th>
                        <th><span class="fa fa-hashtag"></span>Mark</th>
                        <th><span class="fa fa-calendar-alt ic"></span> Visiting Date</th>
                        <th><span class="fa fa-eye"></span> View Job</th>
                    </tr>

                    @foreach($jobs as $job)
                        <tr class="mark" id="job{{$job->id}}">
                            <td>{{$job->category}}
                                

                            </td>
                            <td>
                              @if(!empty($job->artisan))
                                <a href="{{route('view_artisan', $job->artisan->id)}}" data-toggle="tooltip" title="view artisan profile"> {{ $job->artisan->full_name}}</a>
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
                            {{-- {{$job->street_addr}}, 
                                @php
                                    echo str_replace('-', ' ', $job->local_govt);
                                @endphp
                                ,
                                @php 
                                    echo str_replace('_', ' ', $job->state);
                                @endphp --}}
                            </td>
                            <td>
                              @if($job->invoice !== null)
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="view invoice" 
                                onclick="window.location.href='{{route('admin_view_invoice', $job->invoice->id)}}'">
                                <i class="la la-eye"></i>
                              </button>
                              @else
                              No invoice
                              @endif    
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
                                       <a href="" class="btn btn-sm mark completed marked" id="{{$job->id}}" 
                                        data-toggle="tooltip" title="Mark as COMPLETED" style="background-color: green !important; border: 2px solid green;">
                                        <i class="la la-check-circle-o"></i>
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
                                  <span class="la la-calendar"></span>
                                  {!! Carbon\Carbon::parse($job->visiting_date)->format('j F, Y') !!}<br> 
                                  <span class="la la-clock"></span> {{ $job->visiting_time }}
                                <p class="job-status" data-toggle="tooltip" title="{{$job->status}} job">
                                  <i class="la la-tag"></i>
                                  <span id="jab{{$job->id}}" class="{{$job->status}}">{{$job->status}}</span>
                                </p> 
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#job_view{{$job->id}}"><i class="la la-eye"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </table>

                {{-- Jobs Modal --}}
                @foreach($jobs as $job)
                <div class="modal fade" id="job_view{{$job->id}}" tabindex="-1" role="dialog" aria-labelledby="{{$job->category}}" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="{{$job->id}}">{{$job->category}} Job</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Job Type</th>
                                    <td>{{ $job->category }}</td>
                                </tr>
                                <tr>
                                    <th>Owner</th>
                                    <td>
                                      <a href="{{route('view',$job->user->id)}}" data-toggle="tooltip" title="View profile">
                                        {{ $job->user->name }}
                                      </a>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Assigned Artisan</th>
                                    @if(!empty($job->artisan))
                                    <td>
                                      <a href="{{route('view_artisan',$job->artisan->id)}}" data-toggle="tooltip" title="View profile">
                                        {{ $job->artisan->full_name }}
                                      </a>
                                    </td>
                                    @else
                                    <td><span class="badge-pill badge-info">No artisan assigned yet</span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Job Status</th>
                                    <td>{{ $job->status }}</td>
                                </tr>
                                <tr>
                                    <th>Invoice total (&#8358;)</th>
                                    <td>
                                    @if($job->invoice !== null)
                                        {!! number_format($job->invoice->sum_total) !!}
                                        @if($job->invoice->status === 'Paid')
                                            <span class="badge badge-pill badge-success fa fa-check-circle"> Paid</span>
                                        @elseif($job->invoice->status === 'Percentage')
                                            <span class="badge badge-pill badge-info">Paid: 70% ({!! number_format($job->invoice->sum_total * 70/100 ) !!})<br>
                                            Balance: {!! number_format($job->invoice->sum_total * 30/100 ) !!}
                                        @else
                                        <span class="badge badge-pill badge-warning">Unpaid</span>
                                        @endif
                                    @else
                                        <span class="badge badge-pill badge-info"> No Invoice for this job yet</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Start Date:</th>
                                    <td>{{ $job->created_at->format(get_option('date_format')) }}</td>
                                </tr>
                            </table>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                {{-- Job Modals ends --}}

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