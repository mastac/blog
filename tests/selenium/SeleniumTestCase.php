<?php

abstract class SeleniumTestCase extends TestCase
{

//    protected $homepage = 'http://localhost:8000';
    protected $homepage = 'http://web';

    /** @var RemoteWebDriver $driver */
    protected $driver;

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

    protected function setUp()
    {
        parent::setUp();

        $this->driver = RemoteWebDriver::create(
//            'http://localhost:4444/wd/hub',
            'http://selenium:4444/wd/hub',
            DesiredCapabilities::firefox()
        );
    }

    protected function tearDown()
    {
        $this->driver->quit();
        parent::tearDown();
    }

    /**
     * Get sample file to use in upload
     * @return string
     */
    protected function getSampleFileToUpload()
    {
        $sizes = ['750x300', '650x400', '800x400', '700x350'];
        $size = $sizes[mt_rand(0, 3)];
        $origImage = 'http://placehold.it/' . $size;

        $temp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . str_random(10) . '.png';
        file_put_contents($temp, file_get_contents($origImage));
        chmod($temp, 0777);

        return $temp;
    }
}