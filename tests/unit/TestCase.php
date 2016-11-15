<?php

use App\User;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    protected static $user;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Create user and check user exist
     */
    public function createUserAndCheckUserExist()
    {
        self::$user = factory(App\User::class)->create();
        $this->seeInDatabase('users', ['email' => self::$user->email]);
    }

    /**
     * Delete user and check dont exist user
     */
    public function deleteUserAndCheckUserExist()
    {
        $userId = self::$user->id;
        $user = User::find(self::$user->id);
        $user->destroy(self::$user->id);
        $this->dontSeeInDatabase('users', ['id' => $userId]);
        $this->assertDirectoryNotExists(storage_path('app/public/' . $userId));
    }
}
