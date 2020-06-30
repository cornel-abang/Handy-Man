@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered">

                <tr>
                    <th>Subject</th>
                    <th>@lang('app.message')</th>
                    <th>@lang('app.job_action')</th>
                </tr>

                @foreach($flagged as $flag)
                    <tr>
                        <td>
                            <a href="" target="_blank">{{$flag->service['category']}}</a>
                            <p class="text-muted">{{$flag->reason}}</p>
                            <p class="text-muted">
                                {{$flag->created_at->format(get_option('date_format'))}} {{$flag->created_at->format(get_option('time_format'))}}
                            </p>
                        </td>
                        <td> {!! nl2br($flag->message) !!} </td>
                        <td>

                            <p>
                            <a href="" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="@lang('app.view')"><i class="la la-eye"></i> </a>
                            <a href="" class="btn btn-secondary btn-sm"><i class="la la-edit" data-toggle="tooltip" title="@lang('app.edit')"></i> </a>
                            </p>

                            
                                <a href="" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="la la-check-circle-o"></i> </a>
                            

                            
                                <a href="" class="btn btn-warning btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="la la-ban"></i> </a>
                           

                            <a href="" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.delete')"><i class="la la-trash-o"></i> </a>
                            
                            
                        </td>
                    </tr>
                @endforeach

            </table>


            {!! $flagged->links() !!}

        </div>
    </div>



@endsection