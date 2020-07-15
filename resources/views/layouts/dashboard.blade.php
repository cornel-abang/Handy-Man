<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Handiman - {{ !empty($title) ? $title : __('app.dashboard') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/landing/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('assets/landing/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
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
    <link href="{{asset('assets/css/font-awesome-animation.min.css')}}" rel="stylesheet" type="text/css" href="">

    @yield('page-css')

    <!-- Scripts -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

    $allJobsCount = \App\Http\Controllers\ServiceController::allJobs()->count();
    $pendingJobCountAll = \App\Http\Controllers\ServiceController::jobsPendingAll()->count();
    $newJobCountAll = \App\Http\Controllers\ServiceController::newAll()->count();
    $progressJobCountAll = \App\Http\Controllers\ServiceController::progressAll()->count();
    $completedJobCountAll = \App\Http\Controllers\ServiceController::jobsCompletedAll()->count();
    $cancelledJobCountAll = \App\Http\Controllers\ServiceController::jobsCancelledAll()->count();
    $allClients = \App\Http\Controllers\UserController::getUsersCount()->count();
    
    }
    else
    {

    $pendingJobCount = \App\Http\Controllers\ServiceController::jobsPending()->count();
    $newJobCount = \App\Http\Controllers\ServiceController::new()->count();
    $progressJobCount = \App\Http\Controllers\ServiceController::progress()->count();
    $completedJobCount = \App\Http\Controllers\ServiceController::jobsCompleted()->count();
    $cancelledJobCount = \App\Http\Controllers\ServiceController::jobsCancelled()->count();
    $allJobs = App\Http\Controllers\ServiceController::allUserJobsCount()->count();

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
                            <a class="nav-link">
                                <i class="la la-key" style="color: #fdb522; font-weight: bold;"></i>Account ID: 
                                <span style="font-weight: bold;">{{$user->account_id}}</span> 
                            </a>
                        </li>
                        

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="la la-phone" style="color: #fdb522; font-weight: bold;"></i> 
                                Call Assigned Numbers
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="tel:2348149514281">
                                    <i class="la la-phone" style="color: #fdb522; font-weight: bold;"></i> +2348149514281 
                                </a>
                                <a class="dropdown-item" href="tel:2348149514281">
                                    <i class="la la-phone" style="color: #fdb522; font-weight: bold;"></i> +2348149514281 
                                </a>
                            </div>
                        </li>
                        @endif
                         <li class="nav-item">
                          <a href="" class="nav-link">
                            <span class="badge-pill badge-success notification-num">0</span>
                            <i class="la la-bell notification-icon"></i>
                          </a>
                          @if($user->user_type !== 'admin')
                         <li class="nav-item">
                            <a class="nav-link btn btn-success text-white" href="{{ route('request') }}">
                                <i class="fa fa-hard-hat"></i> Request Service 
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div id="main-container" class="main-container">

            <div class="row">
                <div class="col-md-3">

                    <div class="sidebar">
                        <ul class="sidebar-menu list-group">

                            @if($user->user_type === "admin")
                            <li class="">
                                <a href="{{route('dashboard')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-toolbox"></i> </span>
                                    <span class="title">Dashboard</span>
                                </a>
                            </li>


                            <li class="">
                                <a href="{{route('service-categories')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-th-large"></i> </span>
                                    <span class="title">@lang('app.categories')</span>
                                </a>
                            </li>


                            <li class="">
                                <a href="#" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class=""></i>&#8358; </span>
                                    <span class="title">Invocing</span>
                                    <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                </a>

                                <ul class="dropdown-menu" style="display: none;">
                                    <li>
                                        <a class="sidebar-link" href="{{route('all-invoices')}}">All Invoices</a>
                                    </li>
                                    <li>
                                        <a class="sidebar-link" href="{{route('new-invoice')}}">Create New</a>
                                    </li>
                                </ul>
                            </li>

                            @endif

                            @if(($user->user_type === "individual"))
                            <li class="">
                                <a href="{{route('all')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-hard-hat"></i> </span>
                                        <span class="title">Jobs 
                                            <span class="badge badge-success float-right">
                                                {{$allJobs}}
                                            </span>
                                        </span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{route('reschedule-visit')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-handshake"></i> </span>
                                        <span class="title">Reschedule Visit </span>
                                </a>
                            </li>

                             <li class="">
                                <a href="{{route('change_password')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-lock"></i> </span>
                                    <span class="title">@lang('app.change_password')</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('my_flagged_jobs')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-flag"></i> </span>
                                    <span class="title">My Flagged Jobs</span>
                                </a>
                            </li>

                            @endif

                             @if(($user->user_type === "admin"))


                            <li class="">
                                <a href="#" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-hard-hat"></i> </span>
                                    <span class="title">@lang('app.jobs')</span>
                                    <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                </a>

                                <ul class="dropdown-menu" style="display: none;">
                                    <li><a class="sidebar-link" href="{{route('jobs','all')}}">All  <span class="badge badge-success float-right">{{$allJobsCount}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('jobs','new')}}">New  <span class="badge badge-success float-right">{{$newJobCountAll}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('jobs','in-progress')}}">In Progress  <span class="badge badge-info float-right">{{$progressJobCountAll}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('jobs','completed')}}">Completed  <span class="badge badge-success float-right">{{$completedJobCountAll}}</span> </a></li>
                                    <li><a class="sidebar-link" href="{{route('jobs','pending')}}">@lang('app.pending') <span class="badge badge-warning float-right">{{$pendingJobCountAll}}</span></a> </li>
                                    <li><a class="sidebar-link" href="{{route('jobs','cancelled')}}">Cancelled Jobs  <span class="badge badge-danger float-right">{{$cancelledJobCountAll}}</span> </a></li>
                                </ul>
                            </li>

                            <li class="">
                                <a href="" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="la la-users" style="font-weight: bolder;"></i> </span>
                                    <span class="title">Users</span>
                                    <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                </a>

                                <ul class="dropdown-menu" style="display: none;">
                                    <li>
                                        <a class="sidebar-link" href="{{route('clients')}}">Clients  
                                            <span class="badge badge-success fa fa-users float-right"> {{$allClients}}</span> 
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="sidebar-link" href="#">Artisans  
                                            <span class="badge badge-success fa fa-hard-hat float-right"> {{$allClients}}</span>

                                        </a>
                                    </li> --}}
                                    <li class="">
                                        <a href="" class="list-group-item-action">
                                            <span class="sidebar-icon"><i class=""></i> </span>
                                            <span class="title">Artisans</span>
                                            <span class="arrow"><i class="la la-arrow-right"></i> </span>
                                        </a>

                                        <ul class="dropdown-menu" style="display: none;">
                                            <li>
                                                <a class="sidebar-link" href="{{route('artisans')}}">View Artisans  
                                                    <span class="badge badge-success fa fa-hard-hat float-right"> {{$allClients}}</span> 
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sidebar-link" href="{{route('artisan/add')}}">Add Artisan  
                                                    <span class="badge badge-success float-right">
                                                        <i class="fa fa-user-plus"></i>
                                                    </span>
                                                     
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="">
                                <a href="{{route('payments')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-money"></i> </span>
                                    <span class="title">@lang('app.payments')</span>
                                </a>
                            </li>
                           
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

                            <li>
                                <a href="{{route('flagged_jobs')}}" class="list-group-item-action active">
                                    <span class="sidebar-icon"><i class="la la-flag"></i> </span>
                                    <span class="title">Flagged Jobs</span>
                                </a>
                            </li>

                            @endif
                             {{-- <li class="">
                                <a href="{{route('messages')}}" class="list-group-item-action">
                                    <span class="sidebar-icon"><i class="fa fa-envelope"></i> </span>
                                    <span class="title">Message Board<span class="badge badge-success float-right">0 </span></span>
                                </a>
                            </li>
 --}}
                            <li>
                                <a href="{{ route('logout') }}" class="list-group-item-action">
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
                            
                                <img src="{{ asset('assets/images/hat.png') }}" height="50" width="50"> <h3 class="flex-grow-1">{!! ! empty($title) ? $title : __('app.dashboard') !!}</h3>
                            
                            <div class="action-btn-group">@yield('title_action_btn_gorup')</div>
                        </div>

                        <div class="col-md-9">
                            @include('admin.flash_msg')
                        </div>

                        <div class="main-page-content p-4 mb-4">
                            @yield('content')
                        </div>

                        <div class="dashboard-footer mb-3">
                            <a href="{{route('home')}}" target="_blank">Handy Man</a> Version {{config('app.version')}}
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
    <script src="//js.pusher.com/3.1/pusher.min.js" defer></script>
    <link rel="stylesheet" href="{{asset('assets/DataTable/datatables.css') }}">
    <script src="{{asset('assets/DataTable/datatables.js') }}" defer></script>
    
</body>
</html>
