<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear directory public
        $directory = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix()
            . 'public'
            . DIRECTORY_SEPARATOR ;
        File::deleteDirectory($directory, true);

        $this->call(TagsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
