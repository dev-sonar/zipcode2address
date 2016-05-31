<?php
namespace Test\App\Console\Commands;

use Test\App\TestCase;
use Mockery;
use App\ZipcodeTransfer;
use Illuminate\Filesystem\Filesystem;
use Chumper\Zipper\Zipper;
use Ixudra\Curl\Builder as Curl;
use Illuminate\Container\Container;


use App\Console\Commands\ImportZipcode;


class ZipcodeTableCommandTest extends TestCase
{
    public function tearDown()
    {
        app('Illuminate\Contracts\Console\Kernel')->call('migrate:reset');
        parent::tearDown();
        Mockery::close();
    }

    public function setUp()
    {
        parent::setUp();
        app('Illuminate\Contracts\Console\Kernel')->call('migrate');

        $this->filesystem = Mockery::mock(Filesystem::class);
        $this->zipper = Mockery::mock(Zipper::class);
        $this->curl = Mockery::mock(Curl::class);
        $this->transfer = Mockery::mock(ZipcodeTransfer::class);
    }

    public function testinit()
    {
        $obj = new ImportZipcode($this->transfer,$this->zipper,$this->curl,$this->filesystem);
        $this->assertTrue($obj instanceof ImportZipcode);

    }

    public function testfile()
    {

        $this->curl->shouldReceive('to')->andReturn($this->curl);
        $this->curl->shouldReceive('get')->andReturn($this->curl);

        $this->filesystem->shouldReceive('put');
        $this->filesystem->shouldReceive('get');

        $this->curl->shouldReceive('to')->andReturn($this->curl);
        $this->curl->shouldReceive('get')->andReturn('');
        $this->zipper->shouldReceive('make')->andReturn($this->zipper);
        $this->zipper->shouldReceive('extractTo');
        $this->zipper->shouldReceive('close');

        $this->transfer->shouldReceive('csvRead');
        $this->transfer->shouldReceive('getData')->andReturn([]);


        $input = Mockery::mock(\Symfony\Component\Console\Input\InputInterface::class);
        $output = Mockery::mock(\Symfony\Component\Console\Output\OutputInterface::class,\Symfony\Component\Console\Formatter\OutputFormatterInterface::class);
        $output->shouldReceive('getVerbosity')->andReturn($output);;
        $output->shouldReceive('getFormatter')->andReturn($output);
        $output->shouldReceive('setDecorated')->andReturn($output);

        $input->shouldReceive('bind')->andReturn($input);
        $input->shouldReceive('isInteractive')->andReturn($input);
        $input->shouldReceive('hasArgument')->andReturn($input);
        $input->shouldReceive('getArgument')->andReturn($input);
        $input->shouldReceive('validate')->andReturn(true);
        $input->shouldReceive('getOption')->andReturn(null);

        $obj = new ImportZipcode($this->transfer,$this->zipper,$this->curl,$this->filesystem);

        $laravel = Mockery::mock(\Illuminate\Contracts\Foundation\Application::class);
        $obj->setLaravel(new Container());
        $obj->setApplication(app(\Symfony\Component\Console\Application::class));

        $this->assertEquals($obj->run($input,$output),0);
    }
    public function testfire2()
    {
        $data  =<<<__EOD__
01101,060000000,0600000,ホッカイドウ,サッポロシチュウオウク,,北海道,札幌市中央区,,0,0,0,0,0,0,01
01101,064094100,0640941,ホッカイドウ,サッポロシチュウオウク,アサヒガオカ,北海道,札幌市中央区,旭ケ丘,0,0,1,0,0,0,01
__EOD__;
//        file_put_contents(base_path('storage/app/ken_all.csv.new'),$data);

        $input = Mockery::mock(\Symfony\Component\Console\Input\InputInterface::class);
        $output = Mockery::mock(\Symfony\Component\Console\Output\OutputInterface::class,\Symfony\Component\Console\Formatter\OutputFormatterInterface::class);
        $output->shouldReceive('getVerbosity')->andReturn($output);;
        $output->shouldReceive('getFormatter')->andReturn($output);
        $output->shouldReceive('setDecorated')->andReturn($output);
        $this->filesystem->shouldReceive('get')->andReturn($data);


        $input->shouldReceive('bind')->andReturn($input);
        $input->shouldReceive('isInteractive')->andReturn($input);
        $input->shouldReceive('hasArgument')->andReturn($input);
        $input->shouldReceive('getArgument')->andReturn($input);
        $input->shouldReceive('validate')->andReturn(true);
        $input->shouldReceive('getOption')->with('import-only')->andReturn(true);
        $input->shouldReceive('getOption')->with('file-only')->andReturn(false);
        $input->shouldReceive('getOption')->with('url')->andReturn(false);

        $obj = new ImportZipcode($this->transfer,$this->zipper,$this->curl,$this->filesystem);

        $laravel = Mockery::mock(\Illuminate\Contracts\Foundation\Application::class);
        $obj->setLaravel(new Container());
        $obj->setApplication(app(\Symfony\Component\Console\Application::class));

        $this->assertEquals($obj->run($input,$output),0);

    }
}

