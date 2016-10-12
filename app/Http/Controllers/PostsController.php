<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use User;
use Post;
use App\Http\Requests;

class PostsController extends Controller
{
    public function show(Post $post)
    {
        return view('posts/show', compact('post'));
    }

    public function create(Request $request, User $user)
    {
        $this->validate($request, [
            'content' => 'required|min:4|max:500'
        ]);

        $filename = null;
        if($request->hasfile('image')){

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save( public_path('/uploads/images/' . $filename) );
        }

        $user->posts()->create([
            'content' => $request['content'],
            'image' => $filename
        ]);

        return back();
    }
}
