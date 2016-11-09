<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{
    protected static $user;

    /**
     * Create user
     */
    public function testCreateUser()
    {
        self::$user = factory(App\User::class)->create();
    }

    /**
     * A basic test example.
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

    public function testDeleteUser()
    {
        $userId = self::$user->id;
        $user = \App\User::find(self::$user->id);
        $user->destroy(self::$user->id);
        $this->dontSeeInDatabase('users', ['id' => $userId]);
        $this->assertDirectoryNotExists(storage_path('app/public/' . $userId));
    }

}
