<div class="comment">
    <div id="comment" class="comment-{{$comment->id}} clearfix">
        <img src="/uploads/avatars/{{$comment->user->avatar}}" class="comment-avatar">
        <div class="comment-body">
            <a href="/users/{{$comment->user->id}}" class="commenter">{{$comment->user->name}}</a>
            <div class="comment-content">{{$comment->content}}</div>
    </div>
    <div class="comment_likes pull-right" data-comment-id={{$comment->id}}>
        @if (!Auth::user()->already_likes_comment($comment))
            {{--{{ Form::open([ 'method'  => 'post', 'action' => [ 'CommentLikeController@create', $comment->id ], 'class' => 'like-form' ]) }}--}}
            {{--{{ Form::submit("Like ($comment->likes_count)", array('class' => 'like-link btn-link ')) }}--}}
            {{--<button type="submit" class="like-link btn-link">--}}
                {{--Like <span class="glyphicon glyphicon-thumbs-up"></span> ({{$comment->likes_count}})--}}
            {{--</button>--}}
            {{--{{ Form::close() }}--}}
            @include('likes/like', ['model' => $comment])
        @else
            {{--{{ Form::open([ 'method'  => 'delete', 'action' => [ 'CommentLikeController@destroy', $comment->id ], 'class' => 'unlike-form' ]) }}--}}
            {{--{{ Form::submit("Unlike ($comment->likes_count)", array('class' => 'unlike-link btn-link')) }}--}}
            {{--<button type="submit" class="like-link btn-link">--}}
                {{--Unlike <span class="glyphicon glyphicon-thumbs-down"></span> ({{$comment->likes_count}})--}}
            {{--</button>--}}
            {{--{{ Form::close() }}--}}
            @include('likes/unlike', ['model' => $comment])
        @endif
    </div>
    <div class="pull-right timestamp">{{$comment->created_at->diffForHumans()}}</div>
    </div>
</div>