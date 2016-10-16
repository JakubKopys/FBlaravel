<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Comment;
use Like;
use User;
use Post;
use Auth;
use Input;
use Validator;
use Log;
use Illuminate\Support\Facades\View;
use App\Http\Requests;

class PostLikeController extends Controller
{
    public function create(Request $request, Post $post)
    {
        if( !Auth::user()->already_likes_post($post)) {
            $like = new Like;
            $like->likeable_id = $post->id;
            $like->likeable_type = 'App\Post';
            $like->user_id = Auth::user()->id;

            //Auth::user()->likes()->save($like);
            //$comment->increment('likes_count');
            // can also do: $comment->likes()->save($like);

            $like->save();
        }
        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        Like::where([
            ['likeable_id','=',$post->id],
            ['likeable_type','=','App\Post'],
            ['user_id','=',Auth::user()->id]
        ])->first()->delete();

        return back();
    }
}
