<?php

class Selenium3Test extends TestCase
{

    /** @var RemoteWebDriver $driver */
    protected $driver;

    protected function setUp() {

        $capabilities = DesiredCapabilities::firefox();

//        $capabilities.setC
        $this->driver = RemoteWebDriver::create(
            'http://localhost:4444/wd/hub',$capabilities
        );
    }

    protected function tearDown() {
        $this->driver->quit();
    }

    private function waitCountArticles($driver, $count_posts)
    {
        $driver->wait(5, 2000)->until(
            function () use ($driver, $count_posts) {
                $find_count = count($driver->findElements(WebDriverBy::tagName('article')));
                return $find_count === $count_posts;
            }
        );
    }

    public function HomeScroll()
    {

        $this->driver->get('http://localhost:8000');

        $first_count = count($this->driver->findElements(WebDriverBy::tagName('article')));

        $this->assertEquals(5, $first_count);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 10);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 15);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 20);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 25);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 30);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 35);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 40);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 45);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 50);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 55);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 60);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 65);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 70);

        $this->driver->executeScript("window.scrollTo(0, document.body.offsetHeight)");
        $this->waitCountArticles($this->driver, 75);

        $last_count = count($this->driver->findElements(WebDriverBy::tagName('article')));
        $this->assertEquals($last_count, 75);
    }

    public function HomeTitle() {

        $this->driver->get('http://localhost:8000');

        $this->assertEquals(
            'Home page - Laravel',
            $this->driver->getTitle()
        );
    }

    public function testLogin()
    {

        $this->driver->get('http://localhost:8000');

        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('sign_in')));

        $sign_in_button = $this->driver->findElement(WebDriverBy::id('sign_in'));
        $sign_in_button->click();

sleep(1);

        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('email')));

        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('test@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('password');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/div/div/div/div/div/form/div[4]/div/button'))->click();

sleep(1);
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('blog-full-width')));

        $error_msg = $this->driver->findElement(WebDriverBy::xpath('//*[@id="blog-full-width"]/div/div/div/div/div/div/div/div/div/ul/li'))->getText();


        $this->assertEquals($error_msg, "These credentials do not match our records.");

sleep(1);
    }

}