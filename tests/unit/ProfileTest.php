<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
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
     * Change all fields
     *
     * @return void
     */
    public function testProfileChangeAllFileds()
    {
        $this->actingAs(self::$user)
            ->visit('/profile')
            ->type('change_login','name')
            ->type('change_first_name', 'first_name')
            ->type('change_last_name', 'last_name')
            ->press('Save')
            ->seeInField('name', 'change_login')
            ->seeInField('first_name', 'change_first_name')
            ->seeInField('last_name', 'change_last_name');
    }

    /**
     * Set all fields is empty
     *
     * @return void
     */
    public function testProfileChangeAllSetEmpty()
    {
        $this->actingAs(self::$user)
            ->visit('/profile')
            ->type('','name')
            ->type('', 'first_name')
            ->type('', 'last_name')
            ->press('Save')
            ->see('The name field is required.')
            ->see('The first name field is required.')
            ->see('The last name field is required.');
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
