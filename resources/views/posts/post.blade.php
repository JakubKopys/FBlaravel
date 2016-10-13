<li class="post">

<div class="panel panel-default facebook-panel post-{{$post->id}}">
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
    </div>
</div>

</li>