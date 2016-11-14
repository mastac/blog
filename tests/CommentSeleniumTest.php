<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentSeleniumTest extends TestCase
{
    /** @var RemoteWebDriver $driver */
    protected $driver;

    protected function setUp()
    {
        parent::setUp();

        $this->driver = RemoteWebDriver::create(
//            'http://localhost:4444/wd/hub',
            'http://selenium:4444/wd/hub',
            DesiredCapabilities::firefox()
        );
    }

    protected function tearDown()
    {
        $this->driver->quit();
        parent::tearDown();
    }

    public function testComment()
    {

        /**
         * Create User
         */

        // Delete sample user before test
        \App\User::whereEmail('sample_email@gmail.com')->delete();

        $user = factory(App\User::class)->create([
            'name' => 'samplename',
            'first_name' => 'samplename',
            'last_name' => 'samplename',
            'email' => 'sample_email@gmail.com',
            'activated' => 1,
            'password' => bcrypt('secret')
        ]);

        // home
//        $this->driver->get('http://localhost:8000');
        $this->driver->get('http://web');
        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('sign_in')));

        /**
         * Login
         */

        // go to login
        $this->driver->findElement(WebDriverBy::id('sign_in'))->click();

        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('email')));
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('password')));

        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys($user->email);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/div/div/div/div/div/form/div[4]/div/button'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "HOME PAGE"
            )
        );

        /**
         * Create Post "Post to test comments selenium"
         */

        // go to create post
        $this->driver->findElement(WebDriverBy::id("create_post"))->click();

        // check we on create page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "CREATE POST"
            )
        );

        // title
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[1]/input'))
            ->sendKeys('Post to test comments selenium');

        // text
        $this->driver->executeScript("tinyMCE.activeEditor.setContent('Post text to test comments selenium')");

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[6]/input'))
            ->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "USER: SAMPLENAME"
            )
        );

        /**
         * Go to Post
         */
//        $this->driver->get('http://localhost:8000');
        $this->driver->get('http://web');

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "HOME PAGE"
            )
        );

        $this->driver->findElement(WebDriverBy::linkText('Post to test comments selenium'))->click();
        // check we on post page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "POST TO TEST COMMENTS SELENIUM"
            )
        );


        /**
         * Save comment empty
         */
//        $this->driver->findElement(WebDriverBy::id('comment_name'))->sendKeys('Name 1');
        $this->driver->findElement(WebDriverBy::id('comment_save_button'))->click();

        // check we on post page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "POST TO TEST COMMENTS SELENIUM"
            )
        );

        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::xpath('//*[@id="post-comment"]/div/ul/li')
            )
        );

        $alerts = $this->driver->findElements(WebDriverBy::xpath('//*[@id="post-comment"]/div/ul/li'));

        $messages = [];
        foreach ($alerts as $alert) {
            array_push($messages, $alert->getText());
        }

        $this->assertContains("The name field is required.", $messages);
        $this->assertContains("The comment field is required.", $messages);

        /**
         * Save comment with name
         */
        $this->driver->findElement(WebDriverBy::id('comment_name'))->sendKeys('Name only');
        $this->driver->findElement(WebDriverBy::id('comment_save_button'))->click();

        // check we on post page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "POST TO TEST COMMENTS SELENIUM"
            )
        );

        sleep(1);

        $message = $this->driver->findElement(WebDriverBy::xpath('//*[@id="post-comment"]/div/ul/li[1]'))->getText();

        $this->assertContains("The comment field is required.", $message);

        /**
         * Save comment with name and comment text
         */
        $this->driver->findElement(WebDriverBy::id('comment_name'))->sendKeys('Name comment 1 ');
        $this->driver->findElement(WebDriverBy::id('comment_message'))->sendKeys('message commet text');
        $this->driver->findElement(WebDriverBy::id('comment_save_button'))->click();

        // check we on post page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "POST TO TEST COMMENTS SELENIUM"
            )
        );

        sleep(1);

        $comments = $this->driver->findElements(WebDriverBy::xpath('//*[@id="comments"]/div[@class="media"]'));

        $this->assertCount(1, $comments);

        /**
         * Save comment with name and text and fail email address
         */
        $this->driver->findElement(WebDriverBy::id('comment_name'))->sendKeys('Name comment 1 ');
        $this->driver->findElement(WebDriverBy::id('comment_email'))->sendKeys('Email'); // fail
        $this->driver->findElement(WebDriverBy::id('comment_message'))->sendKeys('message commet text');
        $this->driver->findElement(WebDriverBy::id('comment_save_button'))->click();

        // check we on post page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "POST TO TEST COMMENTS SELENIUM"
            )
        );

        sleep(1);

        $message = $this->driver->findElement(WebDriverBy::xpath('//*[@id="post-comment"]/div/ul/li[1]'))->getText();
        $this->assertContains("The email must be a valid email address.", $message);

        /**
         * Save comment with Name , Text , Email
         */

        $this->driver->findElement(WebDriverBy::id('comment_name'))->sendKeys('Name comment - email');
        $this->driver->findElement(WebDriverBy::id('comment_email'))->sendKeys('Email@gmail.com'); // fail
        $this->driver->findElement(WebDriverBy::id('comment_message'))->sendKeys('message commet text - email');
        $this->driver->findElement(WebDriverBy::id('comment_save_button'))->click();

        // check we on post page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "POST TO TEST COMMENTS SELENIUM"
            )
        );

        sleep(1);

        $comments = $this->driver->findElements(WebDriverBy::xpath('//*[@id="comments"]/div[@class="media"]'));

        $this->assertCount(2, $comments);
    }

}
