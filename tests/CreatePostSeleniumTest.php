<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class CreatePostSeleniumTest extends TestCase
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
        chmod($temp, 0777);

        return $temp;
    }

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

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/div/div/div/div/div/form/div[4]/div/button'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "HOME PAGE"
            )
        );

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
            ->sendKeys('Post title selenium');

        // text
        $this->driver->executeScript("tinyMCE.activeEditor.setContent('Create post text')");

        // tags
        $this->driver->findElement(
            WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[3]/span/span[1]/span/ul/li/input')
        )->sendKeys('best tag' . WebDriverKeys::ENTER);

        // TODO: ошибка в докере, помоему проблема с правами, запуск от имени root
//        // image
//        $image_file = $this->getSampleFileToUpload();
//        $this->driver->findElement(WebDriverBy::xpath('//*[@id="image"]'))
//            ->sendKeys($image_file);

        // youtube
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="youtube"]'))
            ->sendKeys('https://www.youtube.com/watch?v=UZPoUYZz7Jc#!');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[6]/input'))
            ->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
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

        // TODO: смотри todo выше, image, свзаные ошибки
//        // check image
//        $image_path = $this->driver->findElement(WebDriverBy::xpath('//*[@id="posts"]/article/div/div[1]/a/img'))
//            ->getAttribute("src");
//
//        $this->assertNotEmpty($image_path);

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

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/div/div/div/div/div/form/div[4]/div/button'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "HOME PAGE"
            )
        );

        // click on my posts
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="top-bar"]/div/nav/div/ul/li[3]/a'))->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "USER: SAMPLENAME"
            )
        );

        // check button edit vibible
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
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "EDIT POST"
            )
        );

        // change title
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[1]/input'))
            ->clear()
            ->sendKeys('change post title');

        // append to content text
        $content = $this->driver->executeScript('return tinyMCE.activeEditor.getContent()');
        $this->driver->executeScript('tinyMCE.activeEditor.setContent("'.$content.' append text '.'")');

        // remove first tag? click on "x"
        $edit_button = $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[3]/span/span[1]/span/ul/li[1]/span'));
        $p = $edit_button->getLocation();
        $this->driver->executeScript("window.scroll(" . $p->getX() . "," . ($p->getY() - 200) . ");");
        $edit_button->click();

        // and add new tag
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[3]/span/span[1]/span/ul/li/input'))
            ->sendKeys('my new tag' . WebDriverKeys::ENTER);

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/form/div[6]/input'))->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "USER: SAMPLENAME"
            )
        );

        // check existing "my new tag"
        $my_tag = $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div[2]/div/div[2]/ul/li[6]/a'))->getText();
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

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/div/div/div/div/div/form/div[4]/div/button'))->click();

        // check we on home page
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "HOME PAGE"
            )
        );

        // click on my posts
        $this->driver->findElement(WebDriverBy::xpath('//*[@id="top-bar"]/div/nav/div/ul/li[3]/a'))->click();

        // check we on my posts
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::textToBePresentInElement(
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
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
                WebDriverBy::xpath('/html/body/section[1]/div/div/div/div/h2[1]'),
                "USER: SAMPLENAME"
            )
        );

        $post_empty = $this->driver->findElement(WebDriverBy::id('posts'))->getText();

        $this->assertEmpty($post_empty);

    }



}
