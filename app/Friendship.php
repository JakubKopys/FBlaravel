<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Friendship extends Model
{
    protected $fillable = ['user_id', 'friend_id', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function friend()
    {
        // $this->belongsTo('App\Post', 'foreign_key');
        return $this->belongsTo('App\User', 'friend_id');
    }

    public static function request($user_id, $friend_id)
    {
        if (!($user_id == $friend_id) && !self::does_friendship_exist($user_id, $friend_id)) {
            DB::transaction(function () use ($user_id, $friend_id) {
                self::create(['user_id' => $user_id, 'friend_id' => $friend_id, 'status' => 'pending']);
                self::create(['user_id' => $friend_id, 'friend_id' => $user_id, 'status' => 'requested']);
            });
        }
    }

    public static function accept($user_id, $friend_id)
    {
        DB::transaction(function () use ($user_id, $friend_id) {
            self::accept_one_side($user_id, $friend_id);
            self::accept_one_side($friend_id, $user_id);
        });
    }

    public static function accept_one_side($user_id, $friend_id)
    {
        $request = self::where([['user_id',$user_id],['friend_id',$friend_id]])->first();
        $request->status = 'accepted';
        $request->save();
    }

    public static function remove($user_id, $friend_id)
    {
        if (self::does_friendship_exist($user_id, $friend_id)) {
            $friendship1 = self::where([['user_id',$user_id],['friend_id',$friend_id]])->first();
            $friendship2 = self::where([['user_id',$friend_id],['friend_id',$user_id]])->first();
            $friendship1->delete();
            $friendship2->delete();
        }
    }

    public static function does_friendship_exist($user_id, $friend_id)
    {
        return self::where([['user_id',$user_id],['friend_id',$friend_id]])->orWhere([['user_id',$friend_id],['friend_id',$user_id]])->exists();
    }
}
