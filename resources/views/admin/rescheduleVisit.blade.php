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

            <form method="post" action="{{route('send-request')}}" id="jobs_form">
                @csrf

                <div class="alert alert-info">

                    <legend><span class="fa fa-info"></span> Reschedule Visit </legend>

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
                        <p class="text-info" style="color: red !important;"> (Important)</p>
                    </label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control {{e_form_invalid_class('visiting_date', $errors)}}" id="visiting_date" value="{{$service->visiting_date}}" name="visiting_date">

                        {!! e_form_error('visiting_date', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('visiting_time')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> Visiting Time
                        <p class="text-info" style="color: red !important;"> (Important)</p>
                    </label>
                    <div class="col-sm-8">
                        <input type="time" class="form-control {{e_form_invalid_class('visiting_date', $errors)}}" id="visiting_time" value="{{ $service->visiting_time }}" name="visiting_time">

                        {!! e_form_error('visiting_time', $errors) !!}
                    </div>
                </div>

                <div class="form-group row"> 
                    <label class="col-sm-4"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Reschedule</button>
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