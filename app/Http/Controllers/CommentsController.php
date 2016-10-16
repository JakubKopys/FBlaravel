<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Post;
use Comment;
use Input;
use User;
use Log;
use Debugbar;
use App\Http\Requests;
use Illuminate\Support\Facades\View;

class CommentsController extends Controller
{
    public function create(Post $post, Request $request)
    {
        $validator = Validator::make($request->input(), [
            'content' => 'required|min:2|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $comment = new Comment;
            $comment->content = $request->input('content');
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $post->id;
            $comment->save();

            // return HTML view of created post to append it.
            return response()->json(['view' => View::make('comments/comment', compact('comment'))->render(), 'count' => $post->comments()->count()]);
        }
      }
}
