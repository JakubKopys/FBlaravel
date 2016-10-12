@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Users</div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Avatar</th>
                    <th>Email</th>
                    <th>ID</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="/users/{{$user->id}}">{{$user->name}}<a/></td>
                        <td><img class="" width="30" height="30" src="/uploads/avatars/{{ $user->avatar }}"></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->id}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection