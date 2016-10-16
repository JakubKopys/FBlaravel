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
use App\Http\Requests;

class CommentLikeController extends Controller
{
    public function create(Request $request, Comment $comment)
    {
        if( !Auth::user()->already_likes_comment($comment)) {
            $like = new Like;
            $like->likeable_id = $comment->id;
            $like->likeable_type = 'App\Comment';
            $like->user_id = Auth::user()->id;

            //Auth::user()->likes()->save($like);
            //$comment->increment('likes_count');
            // can also do: $comment->likes()->save($like);

            $like->save();
        }
        return back();
    }

    public function destroy(Request $request, Comment $comment)
    {
        Like::where([
            ['likeable_id','=',$comment->id],
            ['likeable_type','=','App\Comment'],
            ['user_id','=',Auth::user()->id]
        ])->first()->delete();

        return back();
    }
}
