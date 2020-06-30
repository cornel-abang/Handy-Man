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

                <!--<div class="form-group row {{ $errors->has('job_title')? 'has-error':'' }}">
                    <label for="job_title" class="col-sm-4 control-label"> @lang('app.job_title')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('job_title', $errors)}}" id="job_title" value="{{ old('job_title') }}" name="job_title" placeholder="@lang('app.job_title')">

                        {!! e_form_error('job_title', $errors) !!}
                    </div>
                </div>-->

                <!--<div class="form-group row {{ $errors->has('position')? 'has-error':'' }}">
                    <label for="position" class="col-sm-4 control-label"> @lang('app.position')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('position', $errors)}}" id="position" value="{{ old('position') }}" name="position" placeholder="@lang('app.position')">

                        {!! e_form_error('position', $errors) !!}
                    </div>
                </div>-->

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
                                        Please select a category that best describes the service you're reguesting.
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
                                        @if(Session::has('intended-category') && Session::get('intended-category') == $category->category_name || Session::get('intended-category') == $category->category_slug) selected="selected"
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
                        <input type="datetime-local" class="form-control {{e_form_invalid_class('visiting_date', $errors)}}" id="visiting_date" value="{{ old('visiting_date') }}" name="visiting_date">

                        {!! e_form_error('visiting_date', $errors) !!}
                    </div>
                </div>

                {{-- <div class="form-group row {{ $errors->has('visiting_time')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> Visiting Time
                        <p class="text-info" style="color: red !important;"> (Important)</p>
                    </label>
                    <div class="col-sm-8">
                        <input type="time" class="form-control {{e_form_invalid_class('visiting_date', $errors)}}" id="visiting_time" value="{{ old('visiting_time') }}" name="visiting_time">

                        {!! e_form_error('visiting_time', $errors) !!}
                    </div>
                </div> --}}
                

                <div class="form-group row">
                    <label class="col-sm-4"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>


                <!--<div class="form-group row {{ $errors->has('salary_cycle')? 'has-error':'' }}">
                    <label for="salary_cycle" class="col-sm-4 control-label">@lang('app.salary_cycle')</label>
                    <div class="col-sm-8">

                        <div class="price_input_group">

                            <select class="form-control {{e_form_invalid_class('salary_cycle', $errors)}}" name="salary_cycle">
                                <option value="monthly" {{ old('salary_cycle') == 'monthly' ? 'selected':'' }}>@lang('app.monthly')</option>
                                <option value="yearly" {{ old('salary_cycle') == 'yearly' ? 'selected':'' }}>@lang('app.yearly')</option>
                                <option value="weekly" {{ old('salary_cycle') == 'weekly' ? 'selected':'' }}>@lang('app.weekly')</option>
                                <option value="daily" {{ old('salary_cycle') == 'daily' ? 'selected':'' }}>@lang('app.daily')</option>
                                <option value="hourly" {{ old('salary_cycle') == 'hourly' ? 'selected':'' }}>@lang('app.hourly')</option>

                            </select>

                            {!! e_form_error('salary_cycle', $errors) !!}
                        </div>
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('salary')? 'has-error':'' }}">
                    <label for="salary" class="col-sm-4 control-label"> @lang('app.salary')</label>
                    <div class="col-sm-8">


                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="number" class="form-control {{e_form_invalid_class('salary', $errors)}}" id="salary" value="{{ old('salary') }}" name="salary" placeholder="@lang('app.salary')">
                            </div>
                            <div class="col-md-6">
                                <label> <input type="checkbox" name="is_negotiable" value="1" {{checked('1', old('is_negotiable'))}}> @lang('app.is_negotiable')</label>
                            </div>
                        </div>

                        {!! e_form_error('salary', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('salary_upto')? 'has-error':'' }}">
                    <label for="salary_upto" class="col-sm-4 control-label"> @lang('app.salary_upto')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('salary_upto', $errors)}}" id="salary_upto" value="{{ old('salary_upto') }}" name="salary_upto" placeholder="@lang('app.salary_upto')">

                        <p class="text-info">@lang('app.salary_upto_desc')</p>
                        {!! e_form_error('salary_upto', $errors) !!}
                    </div>
                </div>-->

                <!--<div class="form-group row {{ $errors->has('salary_currency')? 'has-error':'' }}">
                    <label for="salary_currency" class="col-sm-4 control-label">@lang('app.salary_currency')</label>
                    <div class="col-sm-8">

                        <div class="price_input_group">

                            <select class="form-control {{e_form_invalid_class('salary_currency', $errors)}}" name="salary_currency">

                                @foreach(get_currencies() as $currency => $currency_name)
                                    <option value="{{$currency}}">{{$currency}} | {{$currency_name}}</option>
                                @endforeach
                            </select>

                            {!! e_form_error('salary_currency', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('vacancy')? 'has-error':'' }}">
                    <label for="vacancy" class="col-sm-4 control-label"> @lang('app.vacancy')</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control {{e_form_invalid_class('vacancy', $errors)}}" id="vacancy" value="{{ old('vacancy') }}" name="vacancy" placeholder="@lang('app.vacancy')">

                        {!! e_form_error('vacancy', $errors) !!}
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('gender')? 'has-error':'' }}">
                    <label for="gender" class="col-sm-4 control-label">@lang('app.gender')</label>
                    <div class="col-sm-8">
                        <select class="form-control {{e_form_invalid_class('gender', $errors)}}" name="gender" id="gender">
                            <option value="any" {{ old('gender') == 'any' ? 'selected':'' }}>@lang('app.any')</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected':'' }}>@lang('app.male')</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected':'' }}>@lang('app.female')</option>
                            <option value="transgender" {{ old('gender') == 'transgender' ? 'selected':'' }}>@lang('app.transgender')</option>
                        </select>

                        {!! e_form_error('gender', $errors) !!}
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('exp_level')? 'has-error':'' }}">
                    <label for="exp_level" class="col-sm-4 control-label">@lang('app.exp_level')</label>
                    <div class="col-sm-8">
                        <select class="form-control {{e_form_invalid_class('exp_level', $errors)}}" name="exp_level" id="exp_level">
                            <option value="mid" {{ old('exp_level') == 'mid' ? 'selected':'' }}>@lang('app.mid')</option>
                            <option value="entry" {{ old('exp_level') == 'entry' ? 'selected':'' }}>@lang('app.entry')</option>
                            <option value="senior" {{ old('exp_level') == 'senior' ? 'selected':'' }}>@lang('app.senior')</option>
                        </select>

                        {!! e_form_error('exp_level', $errors) !!}
                    </div>
                </div>



                <div class="form-group row {{ $errors->has('job_type')? 'has-error':'' }}">
                    <label for="job_type" class="col-sm-4 control-label">@lang('app.job_type')</label>
                    <div class="col-sm-8">
                        <select class="form-control {{e_form_invalid_class('job_type', $errors)}}" name="job_type" id="job_type">
                            <option value="full_time" {{ old('job_type') == 'full_time' ? 'selected':'' }}>@lang('app.full_time')</option>
                            <option value="internship" {{ old('job_type') == 'internship' ? 'selected':'' }}>@lang('app.internship')</option>
                            <option value="part_time" {{ old('job_type') == 'part_time' ? 'selected':'' }}>@lang('app.part_time')</option>
                            <option value="contract" {{ old('job_type') == 'contract' ? 'selected':'' }}>@lang('app.contract')</option>
                            <option value="temporary" {{ old('job_type') == 'temporary' ? 'selected':'' }}>@lang('app.temporary')</option>
                            <option value="commission" {{ old('job_type') == 'commission' ? 'selected':'' }}>@lang('app.commission')</option>
                            <option value="internship" {{ old('job_type') == 'internship' ? 'selected':'' }}>@lang('app.internship')</option>
                        </select>

                        {!! e_form_error('job_type', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('experience_required_years')? 'has-error':'' }}">
                    <label for="experience_required_years" class="col-sm-4 control-label"> @lang('app.experience_required_years')</label>
                    <div class="col-sm-8">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="number" class="form-control {{e_form_invalid_class('experience_required_years', $errors)}}" id="experience_required_years" value="{{ old('experience_required_years') }}" name="experience_required_years" placeholder="@lang('app.experience_required_years')">
                            </div>
                            <div class="col-md-6">
                                <label> <input type="checkbox" name="experience_plus" value="1" {{checked('1', old('experience_plus'))}} > @lang('app.plus')</label>
                            </div>
                        </div>

                        {!! e_form_error('experience_required_years', $errors) !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('deadline')? 'has-error':'' }}">
                    <label for="deadline" class="col-sm-4 control-label"> @lang('app.deadline')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control {{e_form_invalid_class('deadline', $errors)}} date_picker" id="deadline" value="{{ old('deadline') }}" name="deadline" placeholder="@lang('app.deadline')">

                        {!! e_form_error('deadline', $errors) !!}
                    </div>
                </div>-->

                


                <!--<div class="form-group row {{ $errors->has('skills')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.skills')</label>
                    <div class="col-sm-8">
                        <textarea name="skills" class="form-control {{e_form_invalid_class('skills', $errors)}}" rows="2">{{ old('skills') }}</textarea>
                        {!! $errors->has('skills')? '<p class="help-block">'.$errors->first('skills').'</p>':'' !!}
                        <p class="text-info"> @lang('app.skills_info_text')</p>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('responsibilities')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.responsibilities')</label>
                    <div class="col-sm-8">
                        <textarea name="responsibilities" class="form-control {{e_form_invalid_class('responsibilities', $errors)}}" rows="3">{{ old('responsibilities') }}</textarea>
                        {!! $errors->has('responsibilities')? '<p class="help-block">'.$errors->first('responsibilities').'</p>':'' !!}
                        <p class="text-info"> @lang('app.responsibilities_info_text')</p>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('educational_requirements')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.educational_requirements')</label>
                    <div class="col-sm-8">
                        <textarea name="educational_requirements" class="form-control {{e_form_invalid_class('educational_requirements', $errors)}}" rows="3">{{ old('educational_requirements') }}</textarea>
                        {!! $errors->has('educational_requirements')? '<p class="help-block">'.$errors->first('educational_requirements').'</p>':'' !!}
                        <p class="text-info"> @lang('app.educational_requirements_info_text')</p>
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('experience_requirements')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.experience_requirements')</label>
                    <div class="col-sm-8">
                        <textarea name="experience_requirements" class="form-control {{e_form_invalid_class('experience_requirements', $errors)}}" rows="3">{{ old('experience_requirements') }}</textarea>
                        {!! $errors->has('experience_requirements')? '<p class="help-block">'.$errors->first('experience_requirements').'</p>':'' !!}
                        <p class="text-info"> @lang('app.experience_requirements_info_text')</p>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('additional_requirements')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.additional_requirements')</label>
                    <div class="col-sm-8">
                        <textarea name="additional_requirements" class="form-control {{e_form_invalid_class('additional_requirements', $errors)}}" rows="3">{{ old('additional_requirements') }}</textarea>
                        {!! $errors->has('additional_requirements')? '<p class="help-block">'.$errors->first('additional_requirements').'</p>':'' !!}
                        <p class="text-info"> @lang('app.additional_requirements_info_text')</p>
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('benefits')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.benefits')</label>
                    <div class="col-sm-8">
                        <textarea name="benefits" class="form-control {{e_form_invalid_class('benefits', $errors)}}" rows="3">{{ old('benefits') }}</textarea>
                        {!! $errors->has('benefits')? '<p class="help-block">'.$errors->first('benefits').'</p>':'' !!}
                        <p class="text-info"> @lang('app.benefits_info_text')</p>
                    </div>
                </div>


                <div class="form-group row {{ $errors->has('apply_instruction')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label"> @lang('app.apply_instruction')</label>
                    <div class="col-sm-8">
                        <textarea name="apply_instruction" class="form-control {{e_form_invalid_class('apply_instruction', $errors)}}" rows="3">{{ old('apply_instruction') }}</textarea>
                        {!! $errors->has('apply_instruction')? '<p class="help-block">'.$errors->first('apply_instruction').'</p>':'' !!}
                        <p class="text-info"> @lang('app.apply_instruction_info_text')</p>
                    </div>
                </div>-->

                            </form>



        </div>
    </div>



@endsection




@section('page-js')
    <script src="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js')}}" defer></script>
@endsection