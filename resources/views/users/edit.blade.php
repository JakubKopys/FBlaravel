@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Edit Your Profile</div>
        <div class="panel-body">
            <form class="edit_user" enctype="multipart/form-data" method="POST" action="/users/{{$user->id}}">
                {{method_field('PATCH')}}
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="name" class="form-control" value="{{$user->name}}">
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" value="{{$user->email}}">
                </div>

                <img class="img-thumbnail edit_avatar" width="200" height="200" src="/uploads/avatars/{{ Auth::user()->avatar }}">
                <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                    <!-- image-preview-clear button -->
                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                    </button>
                    <!-- image-preview-input -->
                    <div class="btn btn-default image-preview-input">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title">Browse</span>
                        <input type="file" accept="image/png, image/jpeg, image/gif" name="avatar"/> <!-- rename it -->
                    </div>
                </span>
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
        </div>
    </div>

@endsection