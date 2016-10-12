@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {{$user->name}}
            {{$user->email}}
            <img class="img-thumbnail" width="200" height="200" src="/uploads/avatars/{{ Auth::user()->avatar }}">
            {{$user->id}}
        </div>
    </div>
@endsection