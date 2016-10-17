<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use User;
use Post;
use Auth;
use Input;
use Validator;
use File;
use App\Http\Requests;
use Illuminate\Support\Facades\View;

class PostsController extends Controller
{
    public function show(Post $post)
    {
        return view('posts/show', compact('post'));
    }
    public function edit(Post $post)
    {
        return view('posts/edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => 'required|min:4|max:500'
        ]);


        $filename = $post->image;
        if($request->hasfile('image')){

            // before uploading new image check if user already have one and delete it if he does.
            if ($post->image != null) {
                $old_image = $post->image;
                File::delete($old_image);
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save( public_path('/uploads/images/' . $filename) );
        }

        $post->update([
            'content' => $request['content'],
            'image' => $filename,
        ]);

        return back();

    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|min:4|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $filename = null;
            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save(public_path('/uploads/images/' . $filename));
            }

            $post = Auth::user()->posts()->create([
                'content' => $request->input('content'),
                'image' => $filename
            ]);

            // return HTML view of created post to append it.
            return response()->json(View::make('posts/post', compact('post'))->render());
        }

    }

    // TODO: if there are more than 10 comments redirect to post show page.
    public function more_comments(Post $post)
    {

        $post_comments = $post->comments();
        if ($post_comments->count()< 12) {
            // HTML string accumulator
            $view = null;

            $comments = $post->comments;
            foreach ($comments as $comment) {
                $view .= ((string)View::make('comments/comment', compact('comment'))->render());
            }
            return response()->json(['view' => $view]);
        } else {
            return response()->json(['redirect' => "/posts/$post->id"]);
        }
    }
}
