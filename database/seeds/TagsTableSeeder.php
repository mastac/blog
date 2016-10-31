<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tagList = ['linux', 'windows', 'mac', 'tag1', 'zzz', 'other'];
        for($j = 0; $j < count($tagList); $j++) {
            factory(App\Tag::class)->create(['name' => $tagList[$j]]);
        }

    }
}
