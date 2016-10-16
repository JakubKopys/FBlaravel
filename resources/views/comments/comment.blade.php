<div class="comment">
    <div id="comment" class="comment-{{$comment->id}} clearfix">
      <img src="/uploads/avatars/{{$comment->user->avatar}}" class="comment-avatar">
      <div class="comment-body">
          <a href="/users/{{$comment->user->id}}" class="commenter">{{$comment->user->name}}</a>
          {{$comment->content}}
          <div class="pull-right timestamp">{{$comment->created_at->diffForHumans()}}</div>
      </div>
    </div>
</div>