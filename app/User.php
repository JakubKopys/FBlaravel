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

    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }

    public function friendships() {
        return $this->hasMany('App\Friendship');
    }

    public function accepted_friendships() {
        return $this->friendships()->where([['status','=','accepted'],['user_id','=', $this->id]])
                                   ->orWhere([['status','=','accepted'],['friend_id','=', $this->id]]);
    }

    public function pending_friendships() {
        return $this->friendships()->where([['status','=','pending'],['user_id','=', $this->id]])
                                   ->orWhere([['status','=','pending'],['friend_id','=', $this->id]]);
    }

    public function requested_friendships() {
        return $this->friendships()->where([['status','=','requested'],['user_id','=', $this->id]])
                                   ->orWhere([['status','=','requested'],['friend_id','=', $this->id]]);
    }

    public function friends()
    {
        return $this->hasManyThrough('App\User', 'App\Friendship', 'friend_id', 'id', 'id');
        // It will work only If every new friendships results in two friendsips:
        // Friendship #1:
        // user_id: user_id
        // friend_id: friend_id
        // Friendship #2;
        // user_id: friend_id
        // friend_id: user_id
    }

    public function is_friends_with(self $user)
    {
        return $this->friends()->where('user_id', $user->id)->exists();
    }

    public function already_likes_comment(Comment $comment) {
        $like = Like::where([['user_id', '=', $this->id], ['likeable_id', '=', $comment->id], ['likeable_type', '=', 'App\Comment']])->get();
        return ($like->count() >= 1 ? true : false);
    }

    public function already_likes_post(Post $post) {
        $like = Like::where([['user_id', '=', $this->id], ['likeable_id', '=', $post->id],   ['likeable_type', '=', 'App\Post']])->get();
        return ($like->count() >= 1 ? true : false);
    }
}
