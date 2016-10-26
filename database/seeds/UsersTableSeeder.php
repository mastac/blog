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
        factory(App\User::class, 10)
            ->create()
            ->each(function ($u) {
                for($i = 0; $i < 10; $i++){
                    $post = $u->posts()->save(factory(App\Post::class)->make(['user_id' => $u->id]));
                    $count_comment = random_int(0, 10);
                    $comments = App\Post::find($post->id)->comments();
                    for($j = 0; $j < $count_comment; $j++) {
                        $comments->save(factory(App\Comment::class)->make(['post_id' => $post->id]));
                    }
                }
            });
    }
}
