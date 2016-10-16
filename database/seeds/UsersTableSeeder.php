<?php

use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Jakub',
            'email' => 'example@email.com',
            'password' => bcrypt('foobar'),
            'admin' => true
        ]);
        $posts = array();
        $users = factory(App\User::class, 10)->create();
        foreach($users as $user) {
            $user_posts = factory(App\Post::class, 2)->create([
                'user_id' => $user->id
            ]);
            $posts[] = $user_posts[0];
            $posts[] = $user_posts[1];
        }
        foreach ($posts as $index=>$post) {
            for ($x = 0; $x < 10; $x++) {
                factory(App\Comment::class)->create([
                    'post_id' => $post->id,
                    'user_id' => $users[$x]->id
                ]);
            }
        }
    }
}
