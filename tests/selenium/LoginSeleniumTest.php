<?php

class LoginSeleniumTest extends SeleniumTestCase
{

    /**
     * Wait count tag articles equal count_posts
     * @param $driver
     * @param $count_posts
     */
    private function waitCountArticles($driver, $count_posts)
    {
        $driver->wait(5, 2000)->until(
            function () use ($driver, $count_posts) {
                $find_count = count($driver->findElements(WebDriverBy::tagName('article')));
                return $find_count === $count_posts;
            }
        , "Get count posts: " . $count_posts);
    }

    public function testHomeScroll()
    {

        $this->driver->get($this->homepage);

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('posts')));

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

    public function testHomeTitle() {

        $this->driver->get($this->homepage);

        $home_page_title = $this->driver->findElement(WebDriverBy::xpath('//*[@id="global_page_title"]'))->getText();
        $this->assertEquals(
            'HOME PAGE',
            $home_page_title
        );
    }

    public function testLogin()
    {

        // Delete sample user before test
        \App\User::whereEmail('sample_email@gmail.com')->delete();

        $this->driver->get($this->homepage);

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('sign_in')));

        $sign_in_button = $this->driver->findElement(WebDriverBy::id('sign_in'));
        $sign_in_button->click();

        /**
         * Insert incorrect login
         */
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('email')));
        $this->driver->wait(5)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::id('password')));

        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('test@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('password');

        $this->driver->findElement(WebDriverBy::xpath('//*[@id="login_button"]'))->click();

        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::xpath('//*[@id="system_alerts"]/ul/li')
            )
        ,"incorrect login");

        $error_msg = $this->driver->findElement(WebDriverBy::xpath('//*[@id="login_email_alert"]/strong'))->getText();

        $this->assertEquals($error_msg, "These credentials do not match our records.");

        $this->driver->findElement(WebDriverBy::id('sign_up'))->click();

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('name')));
        $this->driver->findElement(WebDriverBy::id('name'))->sendKeys('samplename');

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('first_name')));
        $this->driver->findElement(WebDriverBy::id('first_name'))->sendKeys('sample_first_name');

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('last_name')));
        $this->driver->findElement(WebDriverBy::id('last_name'))->sendKeys('sample_last_name');

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('email')));
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('sample_email@gmail.com');

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('password')));
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('password-confirm')));
        $this->driver->findElement(WebDriverBy::id('password-confirm'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::id('register_button'))->click();

        // Visible alert with success
        $this->driver->wait(5)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(
                WebDriverBy::xpath('//*[@id="login_alert_success"]')
            )
        ,"success");

        $message_success = $this->driver->findElement(
            WebDriverBy::xpath('//*[@id="login_alert_success"]')
        )->getText();

        $this->assertEquals(trim($message_success), "We sent you an activation code. Check your email.");

        // Check login before activation
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('sample_email@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::id('login_button'))->click();

        sleep(1);// wait to post login, reload page

        $message_need_confirm = $this->driver->findElement(
            WebDriverBy::xpath('//*[@id="login_alert_warning"]')
        )->getText();

        $this->assertEquals(trim($message_need_confirm),
            "You need to confirm your account. We have sent you an activation code, please check your email.");

        sleep(1);

        // Activate user
        \App\User::whereEmail('sample_email@gmail.com')->update(['activated' => 1]);

        // Check login after activation
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('sample_email@gmail.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('secret');

        $this->driver->findElement(WebDriverBy::id('login_button'))->click();

        sleep(1);

        // Home page check
        $this->driver->wait(5)->until(WebDriverExpectedCondition::titleContains('Home page'));
        $this->driver->wait(5)->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('logout_link')));

        sleep(1);

        $home_page_title = $this->driver->findElement(WebDriverBy::xpath('//*[@id="global_page_title"]'))->getText();
        $this->assertEquals(
            'HOME PAGE',
            $home_page_title
        );

        // Delete sample user before test
        \App\User::whereEmail('sample_email@gmail.com')->delete();
    }

}