@extends('layouts.app')

@section('content')
    {{$user->name}}
    {{$user->email}}
    <img class="img-thumbnail" width="200" height="200" src="/uploads/avatars/{{ Auth::user()->avatar }}">
    {{$user->id}}
@endsection