<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    protected static $user;


    public function testCreateUserAndCheckUserExist()
    {
        self::$user = factory(App\User::class)->create();
        $this->seeInDatabase('users', ['email' => self::$user->email]);
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
            ->type(self::$user->email, 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs('/')
            ->assertTrue(\Auth::check());
        ;
    }

    public function testLogout()
    {
        \Auth::loginUsingId(self::$user->id);
        $this->assertTrue(\Auth::check());
        $form = $this->visit('/')->getForm();

        $this->visit('/')
            ->makeRequestUsingForm($form)
            ->seePageIs('/')
            ->see('Sign in')
        ;
    }

}
