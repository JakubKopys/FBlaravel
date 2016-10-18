@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Users</div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Friendship</th>
                    <th>ID</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="/users/{{$user->id}}"><img class="" width="30" height="30" src="/uploads/avatars/{{ $user->avatar }}"> {{$user->name}}</a></td>
                        <td>
                            @if (Auth::user()->is_friends_with($user))
                                Friends
                            @else
                                Not friends
                            @endif
                        </td>
                        <td>{{$user->id}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection