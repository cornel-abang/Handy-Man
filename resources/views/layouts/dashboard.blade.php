<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Handy Man - {{ !empty($title) ? $title : __('app.dashboard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!--DataTable-->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">  
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome-5/css/all.min.css') }}" rel="stylesheet" type="text/css">

    @yield('page-css')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
    </script>

</head>
<body>
@php
$user = auth()->user();

    if($user->user_type === 'admin')
    {

    $allJobsCount = \App\Http\Controllers\ServiceController::alljobs()->count();
    $pendingJobCountAll = \App\Http\Controllers\ServiceController::jobsPendingAll()->count();
    $newJobCountAll = \App\Http\Controllers\ServiceController::newAll()->count();
    $progressJobCountAll = \App\Http\Controllers\ServiceController::progressAll()->count();
    $completedJobCountAll = \App\Http\Controllers\ServiceController::jobsCompletedAll()->count();
    $cancelledJobCountAll = \App\Http\Controllers\ServiceController::jobsCancelledAll()->count();
    
    }
    else
    {

    $pendingJobCount = \App\Http\Controllers\ServiceController::jobsPending()->count();
    $newJobCount = \App\Http\Controllers\ServiceController::new()->count();
    $progressJobCount = \App\Http\Controllers\ServiceController::progress()->count();
    $completedJobCount = \App\Http\Controllers\ServiceController::jobsCompleted()->count();
    $cancelledJobCount = \App\Http\Controllers\ServiceController::jobsCancelled()->count();

    }
@endphp

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('account') }}">
                    <img src="{{asset('assets/images/logo.png')}}" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="{{route('home')}}"><i class="la la-home"></i> @lang('app.view_site')</a> </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if($user->user_type !== 'admin')
                        <li class="nav-item">
                            <a class="nav-link btn btn-success text-white" href="{{ route('request') }}"><i class="la la-save"></i>Request Service </a>
                        </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                <span class="badge badge-warning"><i class="la la-briefcase"></i>{{auth()->user()->premium_jobs_balance}}</span>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <div id="main-container" class="main-container">

            <div class="row">
                <div class="col-md-3">

                    <div class="sidebar">
                        <ul class="sidebar-menu list-group">

                            <li class="">
                                <a href="{{route('dashboard')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-toolbox"></i> </span>
                                    <span class="title">Dashboard</span>
                                </a>
                            </li>

                            @if($user->user_type === "admin")

                            <li class="">
                                <a href="{{route('service-categories')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-th-large"></i> </span>
                                    <span class="title">@lang('app.categories')</span>
                                </a>
                            </li>
                            @endif

                            @if( ($user->user_type === "admin"))


                            <li class="">
                                <a href="#" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class=""></i>&#8358; </span>
                                    <span class="title">Invocing</span>
                                    <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                </a>

                                <ul class="dropdown-menu" style="display: none;">
                                    <li><a class="sidebar-link" href="{{route('new-invoice')}}">Create New</a></li>
                                    <li><a class="sidebar-link" href="{{route('all-invoices')}}">All Invoices</a></li>
                                    <li><a class="sidebar-link" href="{{route('employer_applicant')}}">@lang('app.applicants')</a></li>
                                    <li><a class="sidebar-link" href="{{route('shortlisted_applicant')}}">@lang('app.shortlist')</a></li>
                                    <li><a class="sidebar-link" href="">@lang('app.profile')</a></li>
                                </ul>
                            </li>

                            @endif

                            @if(($user->user_type === "individual") || ($user->user_type === "cooperate") || ($user->user_type === "admin"))


                            <li class="">
                                <a href="#" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-hard-hat"></i> </span>
                                    <span class="title">@lang('app.jobs')</span>
                                    <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                </a>

                                <ul class="dropdown-menu" style="display: none;">
                                    <li><a class="sidebar-link" href="{{route('all-jobs')}}">All  <span class="badge badge-success float-right">{{$allJobsCount}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('new')}}">New  <span class="badge badge-success float-right">{{$newJobCountAll}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('in-progress')}}">In Progress  <span class="badge badge-info float-right">{{$progressJobCountAll}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('completed')}}">Completed  <span class="badge badge-success float-right">{{$completedJobCountAll}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('pending')}}">@lang('app.pending') <span class="badge badge-warning float-right">{{$pendingJobCountAll}}</span></a> </li>
                                    <li><a class="sidebar-link" href="{{route('cancelled')}}">Cancelled Jobs  <span class="badge badge-danger float-right">{{$cancelledJobCountAll}}</span> </a></li>
                                </ul>
                            </li>
                            @endif


                            @if( ($user->user_type === "admin"))
                            <li class="">
                                <a href="#" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="la la-cogs"></i> </span>
                                    <span class="title">@lang('app.settings')</span>
                                    <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                </a>

                                <ul class="dropdown-menu" style="display: none;">
                                    <li><a class="sidebar-link" href="{{route('general_settings')}}">@lang('app.general_settings')</a></li>
                                    <li><a class="sidebar-link" href="{{route('pricing_settings')}}">@lang('app.pricing')</a></li>
                                    <li><a class="sidebar-link" href="{{route('gateways_settings')}}">@lang('app.gateways')</a></li>
                                </ul>
                            </li>


                            <li class="">
                                <a href="{{route('payments')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-money"></i> </span>
                                    <span class="title">@lang('app.payments')</span>
                                </a>
                            </li>
                            @endif

                            @if(($user->user_type === "admin"))

                            {{--
                            <li>
                                <a href="{{route('dashboard')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-user-secret"></i> </span>
                                    <span class="title">@lang('app.administrator')</span>
                                </a>
                            </li>
                            --}}
                            <li class="">
                                <a href="{{route('users')}}" class="list-group-item-action ">
                                    <span class="sidebar-icon"><i class="la la-users"></i> </span>
                                    <span class="title">@lang('app.users')</span>
                                </a>
                            </li>

                            @endif

                            <li class="">
                                <a href="{{route('account')}}" class="list-group-item-action ">
                                    <span class="sidebar-icon"><i class="fa fa-user"></i> </span>
                                    <span class="title">@lang('app.profile')</span>
                                </a>
                            </li>

                             <li class="">
                                <a href="{{route('messages')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-envelope"></i> </span>
                                    <span class="title">Messages <span class="badge badge-success float-right">{{$newJobCountAll}}</span></span>
                                </a>
                            </li>


                            <li class="">
                                <a href="{{route('change_password')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-lock"></i> </span>
                                    <span class="title">@lang('app.change_password')</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('logout') }}" class="list-group-item-action"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="sidebar-icon"><i class="la la-sign-out"></i> </span>
                                    <span class="title">@lang('app.logout')</span>
                                </a>
                            </li>


                        </ul>
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="main-page pr-4">

                        <div class="main-page-title mt-3 mb-3 d-flex">
                            
                                <img src="{{ asset('assets/font-awesome-5/svgs/solid/angle-double-down.svg') }}" height="50" width="50"> <h3 class="flex-grow-1">{!! ! empty($title) ? $title : __('app.dashboard') !!}</h3>
                            
                            <div class="action-btn-group">@yield('title_action_btn_gorup')</div>
                        </div>

                        @include('admin.flash_msg')

                        <div class="main-page-content p-4 mb-4">
                            @yield('content')
                        </div>

                        <div class="dashboard-footer mb-3">
                            <a href="https://www.themeqx.com/product/jobfair-job-board-application" target="_blank">Handy Man</a> Version {{config('app.version')}}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Scripts -->
    @yield('page-js')
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/admin.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('assets/DataTable/datatables.css') }}">
    <script src="{{asset('assets/DataTable/datatables.js') }}"></script>


  <script type="text/javascript">
      $(document).ready(function() 
        {     
          $('#categories').DataTable(); 
        });
    </script>

</body>
</html>
