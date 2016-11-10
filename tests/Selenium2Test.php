<?php

class Selenium2Test extends PHPUnit_Extensions_Selenium2TestCase
{

    public function setUp()
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowserUrl('http://localhost:8000');
        $this->setBrowser('firefox');
    }

    public function tearDown()
    {

    }

    public function testFirst()
    {
        $this->url('/');
        sleep(10);

        $this->execute(array(
            'script' => 'window.scrollTo(0, document.body.scrollHeight);',
            'args'   => array()
        ));
        sleep(10);

        $this->execute(array(
            'script' => 'window.scrollTo(0, document.body.scrollHeight);',
            'args'   => array()
        ));
        sleep(10);

        $this->execute(array(
            'script' => 'window.scrollTo(0, document.body.scrollHeight);',
            'args'   => array()
        ));
        sleep(10);

        $this->assertEquals('Home page - Laravel', $this->title());

        $this->byXPath('//*[@id="sign_in"]')->click();
        sleep(5);
    }

}