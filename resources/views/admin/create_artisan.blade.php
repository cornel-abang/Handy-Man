@extends('layouts.dashboard')
@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><i class="la la-user-plus"></i>{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('full_name') ? ' is-invalid' : '' }}" name="full_name" value="{{ old('full_name') }}" required autofocus>

                                    @if ($errors->has('full_name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="telephone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required >

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Residential Address</label>

                                <div class="col-md-6">
                                    <input id="address" type="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" required>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="state" class="col-md-4 col-form-label text-md-right">State of Origin</label>

                                <div class="col-md-6">
                                    <input id="state" type="text" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" value="{{ old('state') }}" required>

                                    @if ($errors->has('state'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="LGA" class="col-md-4 col-form-label text-md-right">L.G.A of Origin</label>

                                <div class="col-md-6">
                                    <input id="lga" type="text" class="form-control{{ $errors->has('lga') ? ' is-invalid' : '' }}" name="lga" value="{{ old('lga') }}" required>

                                    @if ($errors->has('lga'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lga') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="skill" class="col-md-4 col-form-label text-md-right">Gender</label>
                                
                                <div class="form-check" style="margin-left: 16px;">
                                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Male" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                    <label class="form-check-label" for="exampleRadios2">
                                      Male
                                    </label>
                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                 <div class="form-check" style="margin-left: 15px;">
                                    <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Female" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                    <label class="form-check-label" for="exampleRadios2">
                                      Female
                                    </label>
                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="skill" class="col-md-4 col-form-label text-md-right">Skill</label>

                                <div class="col-md-6">
                                    <select id="skill" type="text" class="form-control{{ $errors->has('skill') ? ' is-invalid' : '' }}" name="skill" value="{{ old('skill') }}" required>
                                        <option value="">--Select Skill Category--</option>
                                        @foreach($category as $cat)
                                        <option value="{{$cat->category}}">{{$cat->category_name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('skill'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('skill') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="la la-save"></i> {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection