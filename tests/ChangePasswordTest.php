<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChangePasswordTest extends TestCase
{
    protected static $user;

    /**
     * Create user
     */
    public function testCreateUser()
    {
        self::$user = factory(App\User::class)->create();
    }

    public function testChangePasswordSetAllFieldEmpty()
    {
        $this->actingAs(self::$user)
            ->visit('/profile/changepassword')
            ->type('','oldpassword')
            ->type('', 'newpassword')
            ->type('', 'newpassword_confirmation')
            ->press('Change password')
            ->see('The oldpassword field is required.')
            ->see('The newpassword field is required.');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testChangePasswordSetIncorrectOldpassword()
    {
        $this->actingAs(self::$user)
            ->visit('/profile/changepassword')
            ->type('zxcv','oldpassword')
            ->type('', 'newpassword')
            ->type('', 'newpassword_confirmation')
            ->press('Change password')
            ->see('The newpassword field is required.');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testChangePasswordSetOldpasswordAnd3CharToNewPassword()
    {
        $this->actingAs(self::$user)
            ->visit('/profile/changepassword')
            ->type('secret','oldpassword')
            ->type('qwe', 'newpassword')
            ->type('qwe', 'newpassword_confirmation')
            ->press('Change password')
            ->see('The newpassword must be at least 6 characters.');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testChangePasswordSetOldpasswordAndNewPassword()
    {
        $this->actingAs(self::$user)
            ->visit('/profile/changepassword')
            ->type('secret','oldpassword')
            ->type('qweqwe', 'newpassword')
            ->type('qweqwe', 'newpassword_confirmation')
            ->press('Change password')
            ->see('Password changed');
    }

    public function testDeleteUser()
    {
        $userId = self::$user->id;
        $user = \App\User::find(self::$user->id);
        $user->destroy(self::$user->id);
        $this->dontSeeInDatabase('users', ['id' => $userId]);
        $this->assertDirectoryNotExists(storage_path('app/public/' . $userId));
    }

}
