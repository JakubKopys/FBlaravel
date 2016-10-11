@extends('layouts.app')

@section('content')

    <h1>Edit Your Profile</h1>

    <form method="POST" action="/users/{{$user->id}}">
        {{method_field('PATCH')}}
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="name" class="form-control" value="{{$user->name}}">
        </div>

        <div class="form-group">
            <input type="email" name="email" class="form-control" value="{{$user->email}}">
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="password">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>

    @if (count($errors))
        <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
    @endif

@endsection