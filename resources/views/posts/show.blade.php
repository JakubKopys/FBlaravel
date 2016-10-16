@extends('layouts.app')


@section('content')
    <div class="panel panel-default facebook-panel post-{{$post->id}}" data-post-id="{{$post->id}}">
        <div class="fb-testimonial-inner">
            <div class="fb-profile">
                <img class="facebook-thumb" src="/uploads/avatars/{{ $post->user->avatar }}">
                <p class="facebook-name">{{$post->user->name}}<br><span class="facebook-date"><a href="">{{$post->created_at->diffForHumans()}}</a> · <i class="fa fa-globe"></i></span></p>
            </div>
            <div class="fb-testimonial-copy fb-content">
                <p>{{$post->content}}</p>
                @if ($post->image)
                    <div>
                        <img class="facebook-image" src="/uploads/images/{{ $post->image }}">
                    </div>
                @endif
            </div>
            @if (Auth::user()->admin || Auth::user() == $post->user)
                <div class="user_links clearfix">
                    {{ Form::open([ 'method'  => 'delete', 'action' => [ 'PostsController@destroy', $post->id ] ]) }}
                    {{ Form::submit('Delete', array('class' => 'delete-link btn btn-danger btn-link pull-right')) }}
                    {{ Form::close() }}
                    <a class="pull-right btn btn-primary btn-link edit-link" href="{{URL::action('PostsController@edit', [$post->id])}}">Edit</a>
                </div>
            @endif
            <div class="comments" data-comments-post-id="{{$post->id}}">
                <div class="post-comments">
                    @each('comments/comment', $post->comments()->orderBy('created_at','desc')->get(), 'comment')
                </div>
                <div class="add-comment form-inline">
                    {{ Form::open(['url' => "/posts/$post->id/comments", 'class'=>'comment-form', 'data-post-id'=>$post->id, 'data-behavior'=>'comment-form']) }}
                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                    <img src="/uploads/avatars/{{Auth::user()->avatar}}" class="comment-avatar">
                    <div class="form-group">
                        {{Form::text('content', null, ['class' => 'comment-content form-control'])}}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection