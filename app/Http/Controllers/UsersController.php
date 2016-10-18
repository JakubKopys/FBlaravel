<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use File;
use Image;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all()->except(Auth::id());;
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

        $filename = $user->avatar;
        if($request->hasfile('avatar')){

            // before uploading new image check if user already have one and delete it if he does.
            if ($user->avatar != null) {
                $old_image = $user->avatar;
                File::delete($old_image);
            }

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename) );
        }

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'avatar' => $filename,
            'password' => bcrypt($request['password'])
        ]);

        return back();
    }
}
