@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($users->count() > 0)
                <p><b>{{$users->total()}}</b> Client(s) found on the system</p>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('app.name')</th>
                        <th>Phone</th>
                        <th>@lang('app.actions')</th>
                    </tr>

                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>{{$user->phone}}</td>

                            <td>
                                <a href="{{route('users_view', $user->id)}}" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="View profile">
                                    <i class="la la-eye"></i> 
                                </a>

                                    {{-- <a href="{{route('user_status', [$user->id, 'approve'])}}" class="btn btn-default btn-sm" data-toggle="tooltip" title="@lang('app.approve')"><i class="la la-ban"></i> </a>

                                    <a href="{{route('user_status', [$user->id, 'block'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="la la-ban"></i> </a>

                                    <a href="{{route('user_status', [$user->id, 'block'])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="@lang('app.block')"><i class="la la-ban"></i> </a>


                                <a href="{{route('users_edit', $user->id)}}" class="btn btn-info btn-sm"><i class="la la-pencil"></i> </a> --}}
                            </td>
                        </tr>
                    @endforeach

                </table>

                {!! $users->links() !!}

            @else
                <h3>@lang('app.there_is_no_user')</h3>
            @endif



        </div>
    </div>



@endsection