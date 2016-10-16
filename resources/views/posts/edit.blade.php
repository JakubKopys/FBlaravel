@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Edit Post
        </div>
        <div class="panel-body">
        @if (count($errors))
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        <div class="edit-post-form">
            <form enctype="multipart/form-data" class="form" method="POST" action="/posts/{{$post->id}}" >
                {{method_field('PATCH')}}
                {{ csrf_field() }}

                <div class="form-group">
                    <textarea id='content' name="content" class="form-control" required>{{ $post->content }}</textarea>
                </div>

                <img class="facebook-image" src="/uploads/images/{{ $post->image }}">
                <div class="input-group image-preview form-group">
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
                            <input id="image" type="file" accept="image/png, image/jpeg, image/gif" name="image"/> <!-- rename it -->
                        </div>
                    </span>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection