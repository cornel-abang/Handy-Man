@extends('layouts.dashboard')


@section('page-css')
    <link href="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection

<style type="text/css">
    .mendatory-mark{
        color: red;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-md-10">

            <form method="post" action="{{route('send-request')}}">
                @csrf
                <fieldset>
                <div class="alert alert-info">

                    <legend><span class="fa fa-tools"></span> Service Type</legend>

                    <div class="form-group row {{ $errors->has('is_premium')? 'has-error':'' }}">
                        <label for="is_premium" class="col-md-4 control-label">
                             @php
                                $name = auth()->user()->name;
                            @endphp
                            <span class="fa fa-user-alt"></span> {{ $name }}
                        </label>
                        <div class="col-md-8">

                                <a style="cursor: default;">
                                    @if(Session::has('intended-category'))
                                        You're requesting for: 
                                        <h5 style="color: #38c172;">
                                            {!!
                                                ucwords(str_replace('-', ' ', 
                                                Session::get('intended-category'))) 
                                            !!}
                                        </h5>
                                    @else
                                        Please select a category that best describes the service you want to reguest.
                                    @endif 
                                </a>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="state" class="col-md-4 control-label">Category:<span class="mendatory-mark">*</span> </label>
                    <div class="col-md-8">
                        <select name="category" class="form-control {{e_form_invalid_class('category', $errors)}} state_options">
                            <option value="">Select Category</option>
                            @if($categories)
                                @foreach($categories as $category)
                                <option value="{{ $category->category_slug}}"
                                        @if(Session::has('intended-category') && Session::get('intended-category') === $category->category_name || Session::get('intended-category') === $category->category_slug)
                                        selected="selected"
                                        @endif
                                         @if(old('category') && $category->category_slug == old('category')) selected="selected" 
                                         @endif >{!! $category->category_name !!}</option>
                                @endforeach
                            @endif

                        </select>
                        {!! e_form_error('category', $errors) !!}
                    </div>
                </div>

            </fieldset>


                <div class="alert alert-info">

                    <legend><span class="fa fa-map-marker"></span> Location Details</legend>

                    <div class="form-group row {{ $errors->has('is_premium')? 'has-error':'' }}">
                        
                        <div class="col-md-8">

                                <a style="cursor: default;">For now, Handy Man is only available in and around the city of Calabar, Cross River State.</a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="state" value="Cross River State">
                <div class="form-group row">
                    <label for="state" class="col-md-4 control-label">Local Government:<span class="mendatory-mark">*</span> </label>
                    <div class="col-md-8">
                        <select name="local_govt" class="form-control {{e_form_invalid_class('local_govt', $errors)}} state_options" id="LGA">
                            <option value="">Select an LGA</option>

                            @if($LGAs)
                                @foreach($LGAs as $lga)
                                    <option value="{{$lga}}" @if(old('local_govt') && $lga == old('local_govt')) selected="selected" @endif >{!! $lga !!}</option>
                                @endforeach
                                @else
                                <option value="Calabar-Municipality">Calabar Municipality</option>
                                <option value="Calabar-South">Calabar South</option>
                            @endif

                        </select>
                        {!! e_form_error('local_govt', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('street_address')? 'has-error':'' }}">
                    <label for="city_name" class="col-sm-4 control-label"> Street: <span class="mendatory-mark">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('street_address', $errors)}}" id="street" value="{{ old('street_address') }}" name="street_address" placeholder="Ex: 27, Spring Road, Essien Town">

                        {!! e_form_error('street_address', $errors) !!}
                    </div>
                </div>

                 <div class="alert alert-info">

                    <legend><span class="fa fa-info"></span> Brief description </legend>

                    <div class="form-group row {{ $errors->has('is_premium')? 'has-error':'' }}">
                        <label for="is_premium" class="col-md-4 control-label">
                             @php
                                $name = auth()->user()->name;
                            @endphp
                            <span class="fa fa-user-alt"></span> {{ $name }}
                        </label>
                        <div class="col-md-8">

                                <a style="cursor: default;">Although a description of the requested service is optional, filling it out will help us understand the situation better.</a>
                        </div>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('description')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.description')<p class="text-info"> (Optional)</p></label>
                    <div class="col-sm-8">
                        <textarea name="description" class="form-control {{e_form_invalid_class('description', $errors)}}" rows="5">{{ old('description') }}</textarea>
                        {!! $errors->has('description')? '<p class="help-block">'.$errors->first('description').'</p>':'' !!}
                        
                    </div>
                </div>

                <div class="alert alert-info">

                    <legend><span class="fa fa-handshake"></span> Schedule Visiting </legend>

                    <div class="form-group row {{ $errors->has('is_premium')? 'has-error':'' }}">
                        <label for="is_premium" class="col-md-4 control-label">
                             @php
                                $name = auth()->user()->name;
                            @endphp
                            <span class="fa fa-user"></span> {{ $name }}
                        </label>
                        <div class="col-md-8">

                                <a style="cursor: default;">Please schedule a visiting date (Date & Time) that works for you, so a team can come over to <span class="fa fa-map-marker"></span> <span id="vis-location">LOCATION </span> and inspect the requested service.<br>
                                    <strong>YOU CAN ALWAYS RESCHEDULE</strong></a>
                        </div>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('visiting_date')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> Visiting Date
                        <p class="text-info" style="color: red !important;"> (Important)</p>
                    </label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control {{e_form_invalid_class('visiting_date', $errors)}}" id="visiting_date" value="{{ old('visiting_date') }}" name="visiting_date" required="">

                        {!! e_form_error('visiting_date', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('visiting_time')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> Visiting Time
                        <p class="text-info" style="color: red !important;"> (Important)</p>
                    </label>
                    <div class="col-sm-8">
                        <select class="form-control {{e_form_invalid_class('visiting_time', $errors)}}" id="visiting_time" value="{{ old('visiting_time') }}" name="visiting_time" required="">
                            <option value="08:00AM">08:00AM</option>
                            <option value="08:30AM">08:30AM</option>
                            <option value="09:00AM">09:00AM</option>
                            <option value="09:30AM">09:30AM</option>
                            <option value="10:00AM">10:00AM</option>
                            <option value="10:30AM">10:30AM</option>
                            <option value="11:00AM">11:00AM</option>
                            <option value="11:30AM">11:30AM</option>
                            <option value="12:00PM">12:00PM</option>
                            <option value="12:30PM">12:30PM</option>
                            <option value="01:00PM">01:00PM</option>
                            <option value="01:30PM">01:30PM</option>
                            <option value="02:00PM">02:00PM</option>
                            <option value="02:30PM">02:30PM</option>
                            <option value="03:00PM">03:00PM</option>
                            <option value="03:30PM">03:30PM</option>
                            <option value="04:00PM">04:00PM</option>
                            <option value="04:30PM">04:30PM</option>
                            <option value="05:00PM">05:00PM</option>
                            <option value="05:30PM">05:00PM</option>
                            <option value="06:00PM">06:00PM</option>
                            <option value="06:30PM">06:30PM</option>
                        </select>
                        {!! e_form_error('visiting_time', $errors) !!}
                    </div>
                </div>
                 <div class="form-group row">
                    <label class="col-sm-4"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success">Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection




@section('page-js')
    <script src="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js')}}" defer></script>
@endsection