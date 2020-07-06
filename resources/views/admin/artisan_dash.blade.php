@extends('layouts.dashboard')


@section('content')

    @if(auth()->user()->is_artisan())
        <div class="row">
            <div class="col-md-4">
                <div class="p-3 mb-3 text-white bg-success">
                    <h4>Current Job</h4>
                    <h5></h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white bg-danger">
                    <h4>Completed Jobs</h4>
                    <h5></h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white bg-dark">
                    <h4>Pending Jobs</h4>
                    <h5></h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 mb-3 text-white bg-info">
                    <h4>Cancelled Jobs</h4>
                    <h5></h5>
                </div>
            </div>

            <div class="col-md-4">
                    <div class="p-3 mb-3 bg-warning">
                        <h4>Total Jobs</h4>
                        <h5></h5>
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