@extends('layouts.dashboard')


@section('content')

    @if(auth()->user()->is_admin())
        <div class="row">
            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-primary">
                    <h4>Total Accounts</h4>
                    <h5>{{$data['usersCount']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-primary">
                    <h4>Total Jobs</h4>
                    <h5>{{$data['jobsCount']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-success">
                    <h4>Completed Jobs</h4>
                    <h5>{{$data['jobsCompleted']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-primary">
                    <h4>Jobs in Progress</h4>
                    <h5>{{$data['jobsProgress']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-warning">
                    <h4>Pending Jobs</h4>
                    <h5>{{$data['jobsPending']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-danger">
                    <h4>Cancelled Jobs</h4>
                    <h5>{{$data['jobsCancelled']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-primary">
                    <h4>Total Artisans</h4>
                    <h5>{{$data['artisansCount']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-success">
                    <h4>Free Artisans</h4>
                    <h5>{{$data['artisansFree']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-warning">
                    <h4>Occupied Artisans</h4>
                    <h5>{{$data['artisansOccupied']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-primary">
                    <h4>Total Invoices</h4>
                    <h5>{{$data['invoicesCount']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-success">
                    <h4>Paid Invoices</h4>
                    <h5>{{$data['invoicesPaid']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-warning">
                    <h4>Unpaid Invoices</h4>
                    <h5>{{$data['invoicesUnpaid']}}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white text-center bg-primary">
                    <h4>Total Payments</h4>
                    <h5>{{$data['paymentsCount']}}</h5>
                </div>
            </div>

        </div>

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

@endsection