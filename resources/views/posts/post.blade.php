<li class="post">

<div class="panel panel-default facebook-panel post-{{$post->id}}" data-post-id="{{$post->id}}">
    <div class="fb-testimonial-inner">
        <div class="fb-profile">
            <img class="facebook-thumb" src="/uploads/avatars/{{ $post->user->avatar }}">
            <p class="facebook-name">{{$post->user->name}}<br><span class="facebook-date">{{link_to("posts/$post->id", $post->created_at->diffForHumans())}} · <i class="fa fa-globe"></i></span></p>
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
        {{ link_to("posts/$post->id/more_comments/", "more comments({$post->comments()->count()})", ['class' => 'more_comments', 'data-post-id'=>$post->id])}}
        <div class="post_likes pull-right" data-post-id="{{$post->id}}">
            @if (!Auth::user()->already_likes_post($post))
                @include('likes/like', ['model' => $post])
            @else
                @include('likes/unlike', ['model' => $post])
            @endif
        </div>
        <div class="comments" data-comments-post-id="{{$post->id}}">
            <div class="post-comments">
                @each('comments/comment', $post->comments()->orderBy('created_at','desc')->take(2)->get(), 'comment')
            </div>
            <div class="add-comment form-inline">
                {{ Form::open(['url' => "/posts/$post->id/comments", 'class'=>'comment-form', 'data-post-id'=>$post->id, 'data-behavior'=>'comment-form']) }}
                <input type="hidden" id="token" value="{{ csrf_token() }}">
                <img src="/uploads/avatars/{{Auth::user()->avatar}}" class="comment-avatar">
                <div class="form-group new-comment-content">
                    {{Form::text('content', null, ['class' => 'comment-content form-control'])}}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

</li>