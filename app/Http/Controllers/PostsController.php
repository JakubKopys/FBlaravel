<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use User;
use Post;
use Auth;
use Input;
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
        if ($request->hasfile('image')) {

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/images/' . $filename));
        }

        $user->posts()->create([
            'content' => $request['content'],
            'image' => $filename
        ]);

        return back();
    }

    public function edit(Post $post)
    {
        return view('posts/edit', compact('post'));
    }

    public function testfunction(Request $request)
    {
        if ($request->isMethod('post')){
            return response()->json(['response' => 'This is post method']);
        }

        return response()->json(['response' => 'This is a get method']);
    }

    public function ajaxcreate(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|min:4|max:500'
        ]);
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

        return response()->json($post);

    }
}
