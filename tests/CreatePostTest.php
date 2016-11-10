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
     * Validate create post with only name
     * Get error
     */
    public function testCreatePostWithOnlyName()
    {
        $this->actingAs(self::$user)
            ->visit('/posts/create')
            ->type('Post title', 'name')
            ->press('Save')
            ->see('The text field is required.')
        ;
    }

    /**
     * Validate create post with only text (content)
     * Get error
     */
    public function testCreatePostWithOnlyContent()
    {
        $this->actingAs(self::$user)
            ->visit('/posts/create')
            ->type('Post content', 'text')
            ->press('Save')
            ->see('The name field is required.')
        ;
    }

    /**
     * Create post with name and text
     */
    public function testCreatePostWithNameAndText()
    {
        $this->actingAs(self::$user)
            ->visit('/posts/create')
            ->type('Post title', 'name')
            ->type('Post body text', 'text')
            ->press('Save')
            ->seeInDatabase('posts', [
                'name' => 'Post title',
                'text' => 'Post body text'
            ])
        ;
    }

    /**
     * Get sample file to use in upload
     * @return string
     */
    private function getSampleFileToUpload()
    {
        $sizes = ['750x300', '650x400', '800x400', '700x350'];
        $size = $sizes[mt_rand(0, 3)];
        $origImage = 'http://placehold.it/' . $size;

        $temp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . str_random(10) . '.png';
        file_put_contents($temp, file_get_contents($origImage));

        return $temp;
    }

    /**
     * Edit post upload image
     */
    public function testEditPostAddImage()
    {

        $post = \App\Post::whereName('Post title')->first();

        $image = $this->getSampleFileToUpload();

        $this->actingAs(self::$user)
            ->seeInDatabase('posts', ['id' => $post->id, 'image' => ''])
            ->visit('/posts/edit/'.$post->id)
            ->attach($image, 'image')
            ->press('Save')
            ->seeInDatabase('posts', ['id' => $post->id, ['image', '<>', '']])
        ;
    }


    /**
     * Edit post add youtube link
     */
    public function testEditPostAddYoutube()
    {
        $youtube = 'https://www.youtube.com/watch?v=UZPoUYZz7Jc';

        $this->actingAs(self::$user)
            ->visit('/')
            ->click('My Posts')
            ->see('Post title')
            ->click('Edit post')
            ->see('Title')
            ->type($youtube, 'youtube')
            ->press('Save')
            ->seeInDatabase('posts', ['name' => 'Post title', 'youtube' => $youtube])
        ;
    }

    public function testEditPostAddNewTag()
    {
        $post = \App\Post::whereName('Post title')->first();
        $form = $this->actingAs(self::$user)
            ->visit('/posts/edit/'.$post->id)->getForm('Save');

        // Add new tag 'New'
        $newTag = new DOMElement('option', 'New');
        $tag_list = $form->get('tag_list');
        $tag_list->addChoice($newTag);
        $tag_list->setValue('New');

        $form->set($tag_list);

        $this->makeRequestUsingForm($form);

        $this->seeInDatabase('tags',['name' => 'New']);

        $this->visit('/tags/New')
            ->see('Post title');

        // Delete tag and check
        \App\Tag::whereName('New')->delete();

        $this->notSeeInDatabase('tags',['name' => 'New']);
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
        $this->assertDirectoryNotExists(storage_path('app/public/' . $userId));
    }

}