<?php
namespace Test;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

/*
    public function setUp()
    {
        parent::setUp();
        app('Illuminate\Contracts\Console\Kernel')->call('migrate');
    }


    public function tearDown()
    {
        app('Illuminate\Contracts\Console\Kernel')->call('migrate:reset');
        parent::tearDown();
    }
*/
    
}
