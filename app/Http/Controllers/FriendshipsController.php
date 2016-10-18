<?php

namespace App\Http\Controllers;

use Friendship;
use Illuminate\Http\Request;
use User;
use Auth;
use App\Http\Requests;

class FriendshipsController extends Controller
{
    public function create(User $friend)
    {
        $user = Auth::user();

        Friendship::request($user->id, $friend->id);

        return back();
    }

    public function update(User $friend)
    {
        $user = Auth::user();

        Friendship::accept($user->id, $friend->id);

        return back();
    }

    public function destroy(User $friend)
    {
        $user = Auth::user();
        Friendship::remove($user->id, $friend->id);

        return back();
    }
}
