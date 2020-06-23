@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-10" >

            <form action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.reason'):</label>
                                        <select class="form-control  {{e_form_invalid_class('reason', $errors)}}" name="reason">
                                            <option value="">@lang('app.select_a_reason')</option>
                                            <option value="applying_problem">@lang('app.applying_problem')</option>
                                            <option value="fraud">@lang('app.fraud')</option>
                                            <option value="duplicate">@lang('app.duplicate')</option>
                                            <option value="spam">@lang('app.spam')</option>
                                            <option value="wrong_category">@lang('app.wrong_category')</option>
                                            <option value="offensive">@lang('app.offensive')</option>
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                                    
                                </div>
            </form>


        </div>
    </div>



@endsection