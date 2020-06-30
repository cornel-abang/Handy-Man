@extends('layouts.dashboard')
@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><i class="fa fa-hard-hat"></i> {{ $artisan->full_name }} - {{$artisan->skill}}</div>

                    <div class="card-body">
                        
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
                                        '<a href = "/admin/view_job/'.$artisan->service->id.'"><span class="badge badge-pill badge-warning">Occupied by <b>'.$artisan->service->user->name.'\'s job</span></a>' 
                                    !!}
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection