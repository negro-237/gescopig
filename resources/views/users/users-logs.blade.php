@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="col-lg-12">

            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date/Time Added</th>
                                    <th>User Roles</th>
                                    <th>User Permissions</th>
                                    <th>Last login at</th>
                                    <th>Last login IP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                                    <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                                    <!--<td>{{$user->getRoleNames()->implode(' ')}}</td>-->
                                    <td>{{$user->getAllPermissions()->pluck('name')->implode(' ')}}</td>
                                    <th>{{$user->last_login_at}}</th>
                                    <th>{{$user->last_login_ip}}</th>
                                    <td>
                                        <a href="{{ route('show-logs', $user->id) }}" class="btn btn-info" target="_blank">Voir les logs
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection