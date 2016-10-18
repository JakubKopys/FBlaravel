<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use User;
use Debugbar;
use App\Http\Requests;

class SearchController extends Controller
{
    public function autocomplete(Request $request){
        $term = $request->get('term');

        $results = array();

        $queries = DB::table('users')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->take(5)->get();

        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->name ];
        }
        Debugbar::info($results);
        return response()->json($results);
    }

    public function searchUser(Request $request)
    {
        Debugbar::info($request['q']);
        $user = DB::table('users')->where('name', $request['q'])->first();
        Debugbar::info($user);
        if ($user)
            return redirect()->action('UsersController@show', ['user' => $user->id]);
        else
            return back();

    }
}
