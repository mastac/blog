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
        $directories = Storage::disk('public')->directories();
        foreach ($directories as $dir) {
            Storage::disk('public')->deleteDirectory($dir);
        }

        $this->call(TagsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
