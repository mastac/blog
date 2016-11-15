<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * Create user
     *
     * @return void
     */
    public function testCreateUser()
    {
        $this->createUserAndCheckUserExist();
    }

    /**
     * Check login with fail data
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
     * Check success login
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

    /**
     * Logout
     *
     * @return void
     */
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

    /**
     * Delete user
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $this->deleteUserAndCheckUserExist();
    }

}
