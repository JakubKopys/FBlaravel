<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Post;
use User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //eager load posts user and posts comments(with theirs users)
        $posts = Post::with('user','comments.user')->orderBy("created_at", "desc")->paginate(5);

        return view('home', compact('posts'));
    }
}
