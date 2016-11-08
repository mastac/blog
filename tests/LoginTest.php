<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(App\User::class)->create();
    }

    protected function tearDown()
    {
        $this->user->destroy($this->user->id);
        parent::tearDown();
    }

    public function testUserExist()
    {
        $this->seeInDatabase('users', ['email' => $this->user->email]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginFail()
    {
        $this->visit('/login')
            ->type('fail.email@gmail.com', 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->see('These credentials do not match our records.');
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $this->visit('/login')
            ->type($this->user->email, 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->assertTrue(\Auth::check());
        ;
    }

    public function testLogout()
    {
        \Auth::loginUsingId($this->user->id);
        $this->assertTrue(\Auth::check());
        $form = $this->visit('/')->getForm();

        $this->visit('/')
            ->makeRequestUsingForm($form)
            ->seePageIs('/')
            ->see('Sign in')
        ;
    }

}
