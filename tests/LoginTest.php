<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginFail()
    {
        $this->visit('/login')
            ->type('taylor@gmail.com', 'email')
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
        $user = factory(App\User::class)->create();
        echo $user->email;
        $this->visit('/login')
            ->type('teresa.jast@example.org'/*$user->email*/, 'email')
            ->type('secret', 'password')
            ->seePageIs('/');

        dd($this);
    }
}
