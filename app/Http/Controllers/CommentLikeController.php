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

class CommentLikeController extends Controller
{
    public function create(Comment $comment)
    {
        if( !Auth::user()->already_likes_comment($comment)) {
            $like = new Like;
            $like->likeable_id = $comment->id;
            $like->likeable_type = 'App\Comment';
            $like->user_id = Auth::user()->id;

            $like->save();
        }

        return response()->json(['view'=>View::make('likes/unlike', ['model'=>$comment])->render(),'count'=>$comment->likes_count]);
    }

    public function destroy(Comment $comment)
    {
        Like::where([
            ['likeable_id','=',$comment->id],
            ['likeable_type','=','App\Comment'],
            ['user_id','=',Auth::user()->id]
        ])->first()->delete();

        return response()->json(['view'=>View::make('likes/like', ['model'=>$comment])->render(),'count'=>$comment->likes_count]);
    }
}
