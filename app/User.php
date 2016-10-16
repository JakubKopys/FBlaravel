<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function already_likes_comment(Comment $comment)
    {
        $like = Like::where([['user_id', '=', $this->id], ['likeable_id', '=', $comment->id],   ['likeable_type', '=', 'App\Comment']])->get();
        return ($like->count() >= 1 ? true : false);
    }

    public function already_likes_post(Post $post)
    {
        $like = Like::where([['user_id', '=', $this->id], ['likeable_id', '=', $post->id],   ['likeable_type', '=', 'App\Post']])->get();
        return ($like->count() >= 1 ? true : false);
    }
}
