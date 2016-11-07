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

        $output = $this->command->getOutput();
        $tagList = App\Tag::all()->pluck('name')->toArray();

        factory(App\User::class, 10) // 10
            ->create()
            ->each(function ($u) use ($output, $tagList) {

                for($i = 0; $i < 10; $i++){

                    $post = $u->posts()->save(factory(App\Post::class)->make(['user_id' => $u->id]));

                    $output->writeln("User id: {$u->id}, Post id: {$post->id}");

                    // Comments
                    $count_comment = random_int(0, 10);
                    $comments = App\Post::find($post->id)->comments();
                    for($j = 0; $j < $count_comment; $j++) {
                        $comments->save(factory(App\Comment::class)->make(['post_id' => $post->id]));
                    }

                    // Tags
                    $tagCount = random_int(0, count($tagList) + 10); // if more then exists then skip etc. no tags
                    if(!empty($tagList[$tagCount])) {
                        $randomCount = random_int(0, count($tagList));
                        $z = 0;
                        while($z <= $randomCount - 1) {
                            $tag_id = App\Tag::whereName($tagList[$z])->first()->id;
                            $post->tags()->attach($tag_id);
                            $z++;
                        }
                    }

                }
            });
    }
}
