<?php

use App\User;

class CreatePostSeleniumTest extends SeleniumTestCase
{

    public function testCreatePost()
    {
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

        // go to login
        $this->driver->findElement(WebDriverBy::id('sign_in'))->click();

        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('email')));
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('password')));

        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys($user->email);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="login_button"]'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "HOME PAGE"
            )
        );

        // go to create post
        $this->driver->findElement(WebDriverBy::id("create_post"))->click();

        // check we on create page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "CREATE POST"
            )
        );

        // title
        $this->driver->findElement(WebDriverBy::xpath('//input[@id=(//label[text()="Title"]/@for)]'))
            ->sendKeys('Post title selenium');

        // text
        $this->driver->executeScript("tinyMCE.activeEditor.setContent('Create post text')");

        // tags
        $this->driver->findElement(
            WebDriverBy::xpath('//*[@id="tags_edit_post"]/span/span[1]/span/ul/li/input')
        )->sendKeys('best tag' . WebDriverKeys::ENTER);

        // image
        $image_file = $this->getSampleFileToUpload();
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="image"]'))
            ->sendKeys($image_file);

        // youtube
        $this->driver->findElement(WebDriverBy:: xpath('//*[@id="youtube"]'))
            ->sendKeys('https://www.youtube.com/watch?v=UZPoUYZz7Jc#!');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="create_post_button"]'))
            ->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "USER: SAMPLENAME"
            )
        );

        // check created post article

        // check title for first post
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::xpath('//*[@id="posts"]/article/div/h2/a')
            )
        );
        $title = $this->driver->findElement(WebDriverBy::xpath('//*[@id="posts"]/article/div/h2/a'))
            ->getText()
        ;

        $this->assertEquals($title, 'Post title selenium');

        // check image
        $image_path = $this->driver->findElement(WebDriverBy::xpath('//*[@id="posts"]/article/div/div[1]/a/img'))
            ->getAttribute("src");

        $this->assertNotEmpty($image_path);

    }

    public function testEditPost()
    {
        // home
//        $this->driver->get('http://localhost:8000');
        $this->driver->get('http://web');
        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('sign_in')));

        // go to login
        $this->driver->findElement(WebDriverBy::id('sign_in'))->click();

        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('email')));
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('password')));

        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('sample_email@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="login_button"]'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "HOME PAGE"
            )
        );

        // click on my posts
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="my_posts"]'))->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "USER: SAMPLENAME"
            )
        );

        // check button edit visible
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::xpath('//*[@id="posts"]/article/div/a[1]')
            )
        );

        // Элемент залазит под верхушку, это ..опа
        $edit_button = $this->driver->findElement(WebDriverBy::xpath('//*[@id="posts"]/article/div/a[2]'));
        $p = $edit_button->getLocation();
        $this->driver->executeScript("window.scroll(" . $p->getX() . "," . ($p->getY() - 200) . ");");
        $edit_button->click();

        // check we on edit post
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "EDIT POST"
            )
        );

        // change title
        $this->driver->findElement(WebDriverBy::xpath('//input[@id=(//label[text()="Title"]/@for)]'))
            ->clear()
            ->sendKeys('change post title');

        // append to content text
        $content = $this->driver->executeScript('return tinyMCE.activeEditor.getContent()');
        $this->driver->executeScript('tinyMCE.activeEditor.setContent("'.$content.' append text '.'")');

        // remove first tag? click on "x" - select2 js lib
        $edit_button = $this->driver->findElement(WebDriverBy::xpath('//*[@id="tags_edit_post"]/span/span[1]/span/ul/li[1]/span'));
        $p = $edit_button->getLocation();
        $this->driver->executeScript("window.scroll(" . $p->getX() . "," . ($p->getY() - 200) . ");");
        $edit_button->click();

        // and add new tag
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="tags_edit_post"]/span/span[1]/span/ul/li/input'))
            ->sendKeys('my new tag' . WebDriverKeys::ENTER);

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="save_edit_post_button"]'))->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "USER: SAMPLENAME"
            )
        );

        // check existing "my new tag"
        $my_tag = $this->driver->findElement(WebDriverBy::xpath('//*[@id="tags_widget"]/ul/li[6]/a'))->getText();
        $this->assertEquals($my_tag, 'my new tag');
    }

    public function testDeletePost()
    {
        // home
//        $this->driver->get('http://localhost:8000');
        $this->driver->get('http://web');
        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('sign_in')));

        // go to login
        $this->driver->findElement(WebDriverBy::id('sign_in'))->click();

        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('email')));
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('password')));

        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('sample_email@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="login_button"]'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "HOME PAGE"
            )
        );

        // click on my posts
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="my_posts"]'))->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "USER: SAMPLENAME"
            )
        );

        // Элемент залазит под верхушку, это ..опа
        $delete_button = $this->driver->findElement(WebDriverBy::xpath('//*[@id="posts"]/article/div/a[3]'));
        $p = $delete_button->getLocation();
        $this->driver->executeScript("window.scroll(" . $p->getX() . "," . ($p->getY() - 200) . ");");
        $delete_button->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('//*[@id="global_page_title"]'),
                "USER: SAMPLENAME"
            )
        );

        $post_empty = $this->driver->findElement(WebDriverBy::id('posts'))->getText();

        $this->assertEmpty($post_empty);

    }



}
