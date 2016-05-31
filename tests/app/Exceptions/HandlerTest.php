<?php
namespace Test\App\Exceptions;

use Mockery;
use Test\App\TestCase;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HandlerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->exception = Mockery::mock(Exception::class);
        $this->request = Mockery::mock(Request::class);
    }
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testinit()
    {
        $obj = new Handler;
        $this->assertTrue($obj instanceof Handler);
    }
    public function testreport()
    {
        $obj = new Handler;

        $this->assertNull($obj->report($this->exception));
    }
    public function testrender()
    {
        $obj = new Handler;

        $this->assertTrue($obj->render($this->request,$this->exception) instanceof Response);
    }
    

}
