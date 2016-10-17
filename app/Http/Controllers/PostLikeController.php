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
    public function create(Post $post)
    {
        if( !Auth::user()->already_likes_post($post)) {
            $like = new Like;
            $like->likeable_id = $post->id;
            $like->likeable_type = 'App\Post';
            $like->user_id = Auth::user()->id;

            $like->save();
        }

        return response()->json(['view'=>View::make('likes/unlike', ['model'=>$post])->render(),'count'=>$post->likes_count]);
    }

    public function destroy(Post $post)
    {
        Like::where([
            ['likeable_id','=',$post->id],
            ['likeable_type','=','App\Post'],
            ['user_id','=',Auth::user()->id]
        ])->first()->delete();

        return response()->json(['view'=>View::make('likes/like', ['model'=>$post])->render(),'count'=>$post->likes_count]);
    }
}
