<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChangePasswordTest extends TestCase
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
     * Change password set all field is empty
     *
     * @return void
     */
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
     * Change password set Incorrect old password
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
     * Change password set old password and 3 chars to new password
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
     * Set old password and new password
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
