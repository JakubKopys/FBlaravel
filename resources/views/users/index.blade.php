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
                                {{ Form::open([ 'method'  => 'delete', 'action' => [ 'FriendshipsController@destroy', $user->id ]]) }}
                                <button type="submit" class="btn-link">
                                    Remove friend
                                </button>
                                {{ Form::close() }}
                            @elseif (Auth::user()->does_have_request_from($user))
                                {{ Form::open([ 'method'  => 'patch', 'action' => [ 'FriendshipsController@update', $user->id ]]) }}
                                <button type="submit" class="btn-link">
                                    Accept
                                </button>
                                {{ Form::close() }}
                            @elseif (Auth::user()->did_send_request_to($user))
                                Pending
                            @else
                                Not friends
                                {{ Form::open([ 'method'  => 'post', 'action' => [ 'FriendshipsController@create', $user->id ]]) }}
                                <button type="submit" class="btn-link">
                                    Add friend
                                </button>
                                {{ Form::close() }}
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