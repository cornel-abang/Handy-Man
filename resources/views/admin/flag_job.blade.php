@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-7" style="margin: 0 auto;">

            <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.reason'):</label>
                                        <select class="form-control  {{e_form_invalid_class('reason', $errors)}}" name="reason">
                                            <option value="">@lang('app.select_a_reason')</option>
                                            <option value="Invoice_overpricing">Invoice overpricing</option>
                                            <option value="Poor_service_quality">Poor service quality</option>
                                            <option value="Incomplete_job">Incomplete job</option>
                                            <option value="Poor_artisan_behavior">Poor artisan behavior</option>
                                            <option value="other">@lang('app.other')</option>
                                        </select>
                                        {!! e_form_error('reason', $errors) !!}
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="email" class="control-label">@lang('app.email'):</label>
                                        <input type="text" class="form-control  {{e_form_invalid_class('email', $errors)}}" name="email">
                                        {!! e_form_error('email', $errors) !!}
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">@lang('app.message'):</label>
                                        <textarea class="form-control  {{e_form_invalid_class('message', $errors)}}" name="message"></textarea>
                                        {!! e_form_error('message', $errors) !!}
                                    </div>
                                {{-- <input type="hidden" name="job_id" value="{{$job->id}}"> --}}
                                    <button type="submit" class="btn btn-primary"><span class="fa fa-flag"></span> Flag</button>
            </form>


        </div>
    </div>



@endsection