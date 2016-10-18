<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Like;
use Friendship;
use Log;
use Debugbar;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Like::saved(function (Like $like) {
            $like->likeable->increment('likes_count');
        });
        Like::deleted(function (Like $like) {
            $like->likeable->decrement('likes_count');
        });

        // delete related friendship
        Friendship::deleted(function(Friendship $friendship) {
            $user_id = $friendship->user_id;
            $friend_id = $friendship->friend_id;
            $friendship = Friendship::where([
                ['user_id',$friend_id],
                ['friend_id',$user_id]
            ])->delete();
        });
    }
}
