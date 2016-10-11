@extends('layouts.app')

@section('content')
    {{$user->name}}
    {{$user->email}}
    {{$user->id}}
@endsection