<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'content'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function getLikesCount()
    {
        return $this->hasMany('App\Like', 'likeable_id')->where([
            ['likeable_id','=',$this->id],
            ['likeable_type','=','App\Comment']
        ])->count();

    }
}
