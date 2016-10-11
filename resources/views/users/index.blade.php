@extends('layouts.app')

@section('content')
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="/users/{{$user->id}}">{{$user->name}}<a/></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->id}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection