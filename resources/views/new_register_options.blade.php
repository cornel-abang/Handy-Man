@extends('layouts.theme')

@section('content')
    <div class="new-registration-page py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="register-account-box jf-shadow p-3">
                        <h2>Individual Account</h2>
                        <p class="icon"><i class="la la-user"></i> </p>
                        <p>Quickly create an account for your personal use. It only takes a few seconds and you're ready to go.</p>
                        <a href="{{route('individual_register')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>

                <!--<div class="col-md-4">
                    <div class="register-account-box jf-shadow  p-3">
                        <h2>@lang('app.employer')</h2>
                        <p class="icon"><i class="la la-black-tie"></i> </p>
                        <p>@lang('app.employer_new_desc')</p>
                        <a href="{{route('register_employer')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>-->

                <div class="col-md-6">
                    <div class="register-account-box jf-shadow  p-3">
                        <h2>Cooperate Account</h2>
                        <p class="icon"><i class="la la-black-tie"></i> </p>
                        <p>Create an account for your company or organization. Few Steps, Lots of Benefits.</p>
                        <a href="{{route('register_agent')}}" class="btn btn-success"><i class="la la-user-plus"></i> @lang('app.register_account') </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
