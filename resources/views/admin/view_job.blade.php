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
                                <td>{{ $job->user->name }}</td>
                            </tr>

                            <tr>
                                <th>Assigned Artisan</th>
                                <td>{{ $job->artisan->full_name }}</td>
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
                                    <span class="badge badge-pill badge-danger">Unpaid</span>
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