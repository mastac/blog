<?php

class GitHubTest extends PHPUnit_Framework_TestCase {

    protected $url = 'http://web';
    /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;

    public function setUp()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://selenium:4444/wd/hub', $capabilities);
    }

    public function tearDown()
    {
        $this->webDriver->close();
    }

    public function testSearch()
    {
        $this->webDriver->get($this->url);

        // find search field by its id
        $search = $this->webDriver->findElement(WebDriverBy::id('sign_in'));
        $search->click();

    }

}