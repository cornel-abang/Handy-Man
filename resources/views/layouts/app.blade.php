<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! !empty($title) ? $title : 'Handy Man' !!}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

     <!-- Favicons -->
    <link href="{{ asset('assets/landing/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('assets/landing/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel {{request()->routeIs('home') ? 'transparent-navbar' : ''}}">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{asset('assets/images/logo.png')}}" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}"><i class="la la-home"></i> @lang('app.home')</a> 
                    </li>
                     <li class="nav-item"><a class="nav-link" href="{{ route('about_us') }}"><i class="la la-hard-hat"></i> About Us </a></li>
                     <li class="nav-item"><a class="nav-link" href="{{route('contact_us')}}"><i class="la la-envelope-o"></i> Contact Us</a> </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                   {{--  <li class="nav-item">
                        <a class="nav-link btn btn-success text-white" 
                        style="background-color: #fdb522; border: 2px solid #fdb522; border-radius: 1px;" href="{{ route('request') }}"><i class="la la-save"></i>Request Service </a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="la la-sign-in"></i> {{ __('app.login') }}</a>
                        </li> --}}
                        @if(request()->routeIs('login'))
                        <li class="nav-item">
                                <a class="nav-link" href="{{ route('new_register') }}"><i class="la la-user-plus"></i>Sign Up</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="la la-sign-in"></i> {{ __('app.login') }}</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{route('account')}}">{{__('app.dashboard')}} </a>


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

        <main class="py-4">
            @yield('content')
        </main>
    </div>

<script src="{{ asset('assets/js/vendor/jquery-1.11.2.min.js') }}"></script>
</body>
</html>
