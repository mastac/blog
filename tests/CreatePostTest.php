<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreatePostTest extends TestCase
{
    protected static $user;

    /**
     * Create user
     */
    public function testCreateUser()
    {
        self::$user = factory(App\User::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreatePost()
    {
        \Auth::loginUsingId(self::$user->id);

        $this->visit('/posts/create')
            ->type('Post title', 'name')
            ->type('Post body text', 'text')
            ->press('Save')
            ->seeInDatabase('posts', [
                'name' => 'Post title',
                'text' => 'Post body text'
            ])
        ;
    }

    public function testEditPost()
    {
        $youtube = 'https://www.youtube.com/watch?v=UZPoUYZz7Jc';

        // TODO: upload file, see https://laracasts.com/discuss/channels/testing/file-upload-unkown-error-with-phpunit?page=1#reply-106568

        $this->actingAs(self::$user)
            ->visit('/')
            ->click('My Posts')
            ->see('Post title')
            ->click('Edit post')
            ->see('Title')
            ->type($youtube, 'youtube')
            ->press('Save')
            ->seeInDatabase('posts', ['youtube' => $youtube])
        ;
    }

    /**
     * Delete post
     *
     * @return void
     */
    public function testDeletePost()
    {
        \Auth::loginUsingId(self::$user->id);

        $post = \App\Post::whereName('Post title')->first();

        $this->visit('/user/' . \Auth::user()->name)
            ->see('Post title')
            ->click('delete-post-' . $post->id)
            ->dontSee('Post title')
        ;
    }

    public function testDeleteUser()
    {
        $userId = self::$user->id;
        $user = \App\User::find(self::$user->id);
        $user->destroy(self::$user->id);
        $this->dontSeeInDatabase('users', ['id' => $userId]);
    }

}
