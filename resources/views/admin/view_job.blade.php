@extends('layouts.dashboard')
@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><i class="fa fa-hard-hat"></i> {{ $job->artisan->full_name }} - {{$job->artisan->skill}}</div>

                    <div class="card-body">
                        
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Job Type</th>
                                <td>{{ $job->category }}</td>
                            </tr>
                            <tr>
                                <th>Owner</th>
                                <td>
                                    <a href="{{route('view', $job->user->id)}}" data-toggle="tooltip" title="view client profile">{{ $job->user->name }}
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <th>Assigned Artisan</th>
                                <td>
                                    <a href="{{route('view_artisan', $job->artisan->id)}}" data-toggle="tooltip" title="view artisan profile">{{ $job->artisan->full_name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Job Status</th>
                                <td>{{ $job->status }}</td>
                            </tr>
                            <tr>
                                <th>Invoice Total </th>
                                <td>
                                @if($job->invoice !== null)
                                <a href="{{route('admin_view_invoice', $job->invoice->id)}}" data-toggle="tooltip" title="view invoice" target="_blank">Invoice #{{$job->invoice->id}}</a><br>
                                    &#8358;{!! number_format($job->invoice->sum_total) !!}
                                    @if($job->invoice->status === 'Paid')
                                        <span class="badge badge-pill badge-success fa fa-check-circle"> Paid</span>
                                    @elseif($job->invoice->status === 'Percentage')
                                        <span class="badge badge-pill badge-info">Paid: 70% (&#8358;{!! number_format($job->invoice->sum_total * 70/100 ) !!})<br>
                                        Balance: &#8358;{!! number_format($job->invoice->sum_total * 30/100 ) !!}
                                    @else
                                    <span class="badge badge-pill badge-warning">Unpaid</span>
                                    @endif
                                @else
                                    <span class="badge badge-pill badge-info fa fa-info"> No Invoice for this job yet</span>
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
            </div>
        </div>



    </div>
@endsection