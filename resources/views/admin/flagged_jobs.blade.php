@extends('layouts.dashboard')

@section('content')
    <div class="row">

        @foreach($flagged as $flag)
        <div class="col-md-4">

            <table class="table table-bordered" >
                <span class="fa fa-envelope" style="position: absolute; color: #38c172;"></span>
                <tr>
                    <th>{{\Illuminate\Support\Str::limit($flag->service['category'], 8, $end='...')}} | 
                        <span class="fa fa-calendar"></span> {{$flag->created_at->format(get_option('date_format'))}} 
                        - </span> {{$flag->created_at->format(get_option('time_format'))}}</th>
                    {{-- <th>@lang('app.job_action')</th> --}}
                </tr>

                    <tr>
                        <td> {!! \Illuminate\Support\Str::limit(nl2br($flag->message), 1, 
                            $end="<a href='' data-toggle='modal' style='color: #38c172'><span class='fa fa-arrow-alt-circle-right'></span></a>") 
                        !!} </td>
                        {{-- <td>

                            <p>
                            <a href="" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="@lang('app.view')"><i class="la la-eye"></i> </a>
                            <a href="" class="btn btn-secondary btn-sm"><i class="la la-edit" data-toggle="tooltip" title="@lang('app.edit')"></i> </a>
                            </p>

                            
                                <a href="" class="btn btn-success btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="la la-check-circle-o"></i> </a>
                            

                            
                                <a href="" class="btn btn-warning btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="la la-ban"></i> </a>
                           

                            <a href="" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.delete')"><i class="la la-trash-o"></i> </a>
                            
                            
                        </td> --}}
                    </tr>
                

            </table>


            
        </div>
        @endforeach

        {!! $flagged->links() !!}
    </div>



@endsection