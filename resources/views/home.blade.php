@extends('layouts.app')

@section('content')

    <div class="post-form">
        <form enctype="multipart/form-data" class="form" method="POST" action="/users/{{Auth::user()->id}}/posts" id="post_form">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea id='content' name="content" class="form-control" required></textarea>
            </div>

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
                <button type="submit" class="btn btn-primary">Add Post</button>
            </div>
        </form>
    </div>

    <div class="form-toggle"><a href="#">Add Post</a></div>
    <div class="posts">
        <ul id="posts">
            @each('posts/post', $posts, 'post')
        </ul>
        {!! $posts->links() !!}
    </div>

@endsection
