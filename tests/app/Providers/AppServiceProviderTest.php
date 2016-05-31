<?php
namespace Test\App\Providers;

use Test\App\TestCase;
use Mockery;

use App\Providers\AppServiceProvider;

class AppServiceProviderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->laravel = Mockery::mock(\Illuminate\Contracts\Foundation\Application::class);
    }
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testinit()
    {
        $obj = new AppServiceProvider($this->laravel);
        $this->assertTrue($obj instanceof AppServiceProvider);
        $this->assertNull($obj->register());


    }

}
