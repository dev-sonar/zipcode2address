<?php
namespace Test\App\Http\Controllers;

use Test\App\TestCase;
use Mockery;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;


class ZipcodeTableCommandTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        app('Illuminate\Contracts\Console\Kernel')->call('migrate');
        $this->request = Mockery::mock(Request::class);
    }
    public function tearDown()
    {
        app('Illuminate\Contracts\Console\Kernel')->call('migrate:reset');
        parent::tearDown();
        Mockery::close();
    }

    public function testinit()
    {
        $obj = new MainController;

        $this->assertTrue($obj instanceof MainController);

    }
    public function testindex()
    {
        $obj = new MainController;
        $this->assertTrue($obj->index($this->request) instanceof View);
    }
    public function testjs()
    {
        $obj = new MainController;
        $this->assertTrue($obj->js() instanceof Response);
    }

    public function testgetById()
    {
        $this->request->shouldReceive('input')->with('id')->andReturn(1);
        $obj = new MainController;
        $this->assertTrue($obj->getById($this->request) instanceof JsonResponse);
    }
    public function testgetByZipcode()
    {
        $this->request->shouldReceive('input')->with('code')->andReturn(1);
        $obj = new MainController;
        $this->assertTrue($obj->getByZipcode($this->request) instanceof JsonResponse);
    }

}
