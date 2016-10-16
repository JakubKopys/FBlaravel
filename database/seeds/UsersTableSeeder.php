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
        $users = factory(App\User::class, 10)->create();
        foreach($users as $user) {
            $posts = factory(App\Post::class, 10)->create([
                'user_id' => $user->id
            ]);
            foreach ($posts as $post) {
                for ($x = 0; $x <= 10; $x++) {
                    $post->comments()->save(factory(App\Comment::class)->make());
                }
            }
        }
    }
}
