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
        // Clear directory public, except file .gitignore
        $directory = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'public' ;
        $directories = File::directories($directory);
        foreach ($directories as $dir) {
            File::deleteDirectory($dir . DIRECTORY_SEPARATOR, true);
        }

        $this->call(TagsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
