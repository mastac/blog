<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {

    static $password = '123123';

    return [
        'name' => $faker->userName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Post::class, function (Faker\Generator $faker) {

    // Content
    $content = '';
    foreach ($faker->paragraphs(random_int(3,10)) as $paragraph) {
        $content .= '<p>'.$paragraph.'</p>';
    }

    // Youtube
    $youtubeIds = [
        '6C7opaKZwEE',
        'X8Z8okhkjv8',
        'FZ1H12zTm_k',
        '0hMTcCYdg04',
        '4LJ_yHWDRDw',
        'ZKRVaArIxo4',
        'rrCVCh_Lq2Y',
        'fXLEmubJzkU',
        'CrkFewN5aEY',
        'FwDaOcotclY',
        'hyqXU72Oqbs',
        'aAIreF0GM2k'
    ];
    $youtubeRandomId = random_int(0, count($youtubeIds)+2);
    $youtube = '';
    if (isset($youtubeIds[$youtubeRandomId]))
        $youtube = $youtubeIds[$youtubeRandomId];

    // User
    $user_id = factory(App\User::class)->create()->id;

    // Image
//    $sizes = ['180x370', '370x180', '370x370', '370x560', '560x370'];
//    $size = explode('x', $sizes[mt_rand(0, 4)]);
//    $origImage = 'http://lorempixel.com/' .  implode('/', $size);
//
//    $image_filename = str_random(10) . '.png';
//    $image =  Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . '/public/1/' . $image_filename;
//
//    file_put_contents($image, file_get_contents($origImage));
    $image_filename = '';

    return [
        'name' => $faker->text,
        'text' => $content,
        'youtube' => $youtube,
        'image' => $image_filename,
        'user_id' => $user_id
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'comment' => $faker->text,
        'post_id' => function () {
            return factory(App\Post::class)->create()->id;
        }
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});