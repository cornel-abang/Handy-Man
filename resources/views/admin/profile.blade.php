@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($user->is_employer() || $user->is_agent())
                <div class="profile-company-logo mb-3">
                    <img src="{{$user->logo_url}}" class="img-fluid" style="max-width: 100px;" />
                </div>
            @endif

            <table class="table table-bordered table-striped mb-4">

                <tr>
                    <th>@lang('app.name')</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>@lang('app.email')</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>@lang('app.phone')</th>
                    <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                    <th>Account ID</th>
                    <td>{{ ($user->account_id) }}</td>
                </tr>
                <tr>
                    <th>Jobs</th>
                    <td>
                       @foreach($user->services as $job)
                       <span class="fa fa-arrow-circle-right"></span>
                       {{ $job->category }} 
                       @if($job->status === 'Completed')
                       <span class="badge badge-pill badge-success">Completed</span>
                       @elseif($job->status === 'Cancelled')
                       <span class="badge badge-pill badge-danger">Cancelled</span>
                       @elseif($job->status === 'Pending')
                       <span class="badge badge-pill badge-warning">Pending</span>
                       @elseif($job->status === 'In-Progress')
                       <span class="badge badge-pill badge-info">In Progress</span>
                       @else
                       <span class="badge badge-pill badge-primary">New</span>
                       @endif
                       <br>
                       @endforeach()
                    </td>
                </tr>

                <tr>
                    <th>Signed Up Date</th>
                    <td><span class="fa fa-calendar"></span> {{$user->created_at->format(get_option('date_format')) }} 
                         <span class="fa fa-clock"></span> {{ $user->created_at->format(get_option('time_format')) }}</td>
                </tr>
            </table>




            @if($user->is_employer() || $user->is_agent())
                    <h3 class="mb-4">About Company</h3>

                    <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('app.state')</th>
                        <td>{{ $user->state_name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.city')</th>
                        <td>{{ $user->city }}</td>
                    </tr>

                    <tr>
                        <th>@lang('app.website')</th>
                        <td>{{ $user->website }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.company')</th>
                        <td>{{ $user->company }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.company_size')</th>
                        <td>{{company_size($user->company_size)}}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.about_company')</th>
                        <td>{{ $user->about_company }}</td>
                    </tr>
                    <tr>
                        <th>@lang('app.premium_jobs_balance')</th>
                        <td>{{ $user->premium_jobs_balance }}</td>
                    </tr>
                </table>
            @endif


        </div>
    </div>



@endsection