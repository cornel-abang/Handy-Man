@extends('layouts.dashboard')


@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($artisans->count() > 0)
                <p><b>{{$artisans->total()}}</b> Artisan(s) found on the system</p>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>@lang('app.name')</th>
                        <th>Skill</th>
                        <th>@lang('app.actions')</th>
                    </tr>

                    @foreach($artisans as $artisan)
                        <tr>
                            <td>
                                {{ $artisan->full_name}}
                            </td>
                            <td>{{ $artisan->skill}}</td>

                            <td>
                                <a href="" class="btn btn-secondary btn-sm" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#artisan{{$artisan->id}}">
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

                {!! $artisans->links() !!}

            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="no data-wrap py-5 my-5 text-center">
                            <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                            <h1>No Data available here</h1>
                        </div>
                    </div>
                </div>
            @endif



        </div>
    </div>
    
@foreach($artisans as $artisan)
<!-- Modal -->
<div class="modal fade" id="artisan{{$artisan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-hard-hat"></span> {{$artisan->full_name}} - {{$artisan->skill}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Full Name</th>
                                <td>{{ $artisan->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Phone Nmmber</th>
                                <td>{{ $artisan->phone }}</td>
                            </tr>

                            <tr>
                                <th>Email Adress</th>
                                <td>{{ $artisan->email }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $artisan->address }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{$artisan->gender}}</td>
                            </tr>
                            <tr>
                                <th>Skill</th>
                                <td>{{ $artisan->skill }}</td>
                            </tr>
                            <tr>
                                <th>Work Status</th>
                                <td>
                                    {!! 
                                        $artisan->status === 'free'? '<span class="badge badge-pill badge-success">Free</span>' :
                                        '<a href = "view_job/'.$artisan->service->id.'"><span class="badge badge-pill badge-warning">Occupied by <b>'.$artisan->service->user->name.'\'s job</span></a>' 
                                    !!}
                                </td>
                            </tr>
                        </table>
      </div>
    </div>
  </div>
</div>
@endforeach


@endsection