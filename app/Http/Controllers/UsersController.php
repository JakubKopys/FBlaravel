<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
           'name' => 'required|min:4|max:20|unique:users,name,'.$user->id,
           'email' => 'email|unique:users,email,'.$user->id,
           'password' => 'min:4|max:255'
        ]);

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        return back();
    }
}
