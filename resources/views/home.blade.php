@extends('layouts.app')

@section('content')

    <div class="post-form">
        <form enctype="multipart/form-data" class="form" method="POST" action="/users/{{Auth::user()->id}}/posts">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea name="content" class="form-control" required></textarea>
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
                            <input type="file" accept="image/png, image/jpeg, image/gif" name="image"/> <!-- rename it -->
                        </div>
                    </span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Post</button>
            </div>
        </form>
    </div>

    <div class="form-toggle"><a href="#">Add Post</a></div>

    @foreach($posts as $post)
        {{--<div class="panel panel-default post-{{$post->id}}">--}}
            {{--<div class="panel-heading">--}}
                {{--<img class="img-thumbnail" width="50" height="50" src="/uploads/avatars/{{ $post->user->avatar }}">--}}
                {{--{{$post->user->name}}--}}
                {{--<small class="pull-right">{{$post->created_at->diffForHumans()}}</small>--}}
            {{--</div>--}}
            {{--<div class="panel-body">--}}
                {{--<div>--}}
                    {{--{{$post->content}}--}}
                    {{--@if ($post->image)--}}
                        {{--<div>--}}
                            {{--<img width="300" src="/uploads/images/{{ $post->image }}">--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="panel panel-default">
            <div class="fb-testimonial-inner">
                <div class="fb-profile">
                    <img class="facebook-thumb" src="/uploads/avatars/{{ $post->user->avatar }}">
                    <p class="facebook-name">{{$post->user->name}}<br><span class="facebook-date"><a href="">{{$post->created_at->diffForHumans()}}</a> · <i class="fa fa-globe"></i></span></p>
                </div>
                <div class="fb-testimonial-copy">
                    <p>{{$post->content}}</p>
                </div>
            </div>
        </div>
    @endforeach

@endsection
