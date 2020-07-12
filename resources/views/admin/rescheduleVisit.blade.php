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

            <form method="post" action="" id="jobs_form">
                @csrf

                <div class="alert alert-info">

                    <legend><span class="fa fa-handshake"></span> Reschedule Visit </legend>

                    <div class="form-group row">
                        <label for="is_premium" class="col-md-4 control-label">
                            
                        </label>
                        <div class="col-md-8">
                            <a style="cursor: default;">Please select the job you want to reschedule visit</a>

                                {{-- <a style="cursor: default;">Please schedule a visiting date that works for you, so a team can come over to <span class="fa fa-map-marker"></span> <span id="vis-location"> </span> and inspect the requested service.</a> --}}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="state" class="col-md-4 control-label">Jobs: </label>
                    <div class="col-md-8">
                        <div style="position: absolute; display: none;" id="loaderImg" class="">
                        <img src="{{asset('assets/loader/loader.gif')}}" height="80" width="80">
                    </div>
                        <select name="job" class="form-control {{e_form_invalid_class('job', $errors)}}" id="job_select">
                            <option value="">--Select Job--</option>

                            @if($services)
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->category }}</option>
                                @endforeach
                            @endif

                        </select>
                    
                        {!! e_form_error('job', $errors) !!}
                    </div>
                </div>

            <div class="show-result" id="result">
               <div class="form-group row {{ $errors->has('visiting_date')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> Visiting Date
                    </label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control {{e_form_invalid_class('visiting_date', $errors)}}" id="visiting_date" value="{{$service->visiting_date}}" name="visiting_date">
                        <small class="fa fa-calendar old"> Old Date: <span class="text-info" id="old_date"></span></small>

                        {!! e_form_error('visiting_date', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('visiting_time')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> Visiting Time
                    </label>
                    <div class="col-sm-8">
                        <select class="form-control {{e_form_invalid_class('visiting_time', $errors)}}" id="visiting_time" value="{{ old('visiting_time') }}" name="visiting_time">
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
                        <small class="fa fa-clock old"> Old Time: <span class="text-info" id="old_time"></span></small>

                        {!! e_form_error('visiting_time', $errors) !!}
                    </div>
                </div>

                <div class="form-group row"> 
                    <label class="col-sm-4"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success">Reschedule</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection




@section('page-js')
    <script src="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js')}}" defer></script>
@endsection