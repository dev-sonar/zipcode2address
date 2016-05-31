<?php
namespace Test\App\ZipcodeTransfer;

use Test\TestCase;
use Mockery;

use App\ZipcodeTransfer;

class ZipcodeTransferTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testInstance()
    {
        $obj = new ZipcodeTransfer;

        $this->assertTrue($obj instanceof ZipcodeTransfer);
    }

    public function testCsvRecord()
    {
        $obj = new ZipcodeTransfer;
        $csv = [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15' ];
        $csv2 = [ 'A1', 'A2', '3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15' ];
        $csv3 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];
        $csv4 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'C6', 'B7', 'C8', 'C9', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];
        $csv5 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'C6', 'B7', 'C8', 'C9', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];
        $csv6 = [ 'D1', 'D2', 'D3', 'D4', 'D5', 'D6（', 'D7', 'D8','以下に掲載がない場合', 'D10', 'D11', 'D12', 'D13', 'D14', 'D15' ];
        $csv7 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'C6', 'B7', 'C8', 'C9（', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];
        $csv8 = [ 'D1', 'D2', 'D3', 'D4', 'C5','イカニケイサイガナイバアイ', 'D7', 'D8','以下に掲載がない場合', 'D10', 'D11', 'D12', 'D13', 'D14', 'D15' ];

        $this->assertNull($obj->csvRecord($csv));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertNull($obj->csvRecord($csv3));
        $this->assertNull($obj->csvRecord($csv4));
        $this->assertNull($obj->csvRecord($csv5));
        $this->assertNull($obj->csvRecord($csv6));
        $this->assertNull($obj->csvRecord($csv7));
        $this->assertNull($obj->csvRecord($csv8));

        $this->assertTrue($obj->getData() != '');
    }

    public function testCsvRecord2()
    {
        $obj = new ZipcodeTransfer;
        $csv1 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];
        $csv2 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'C6', 'B7', 'C8', 'C9', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];

        $this->assertNull($obj->csvRecord($csv1));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertTrue($obj->getData() != '');
    }

    public function testCsvRecord3()
    {
        $obj = new ZipcodeTransfer;
        $csv1 = [ 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11', 'A12', '1', 'A14', 'A15' ];
        $csv2 = [ 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11', 'A12', '1', 'A14', 'A15' ];

        $this->assertNull($obj->csvRecord($csv1));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertTrue($obj->getData() != '');
    }

    public function testCsvRecord4()
    {
        $obj = new ZipcodeTransfer;
        $csv1 = [ 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11', 'A12', '0', 'A14', 'A15' ];
        $csv2 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];

        $this->assertNull($obj->csvRecord($csv1));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertTrue($obj->getData() != '');
    }
    public function testCsvRecord5()
    {
        $obj = new ZipcodeTransfer;
        $csv1 = [ 'A1', 'A2', 'A3', 'A4', 'A5', 'A6(', 'A7', 'A8', 'A9(', 'A10', 'A11', 'A12', '0', 'A14', 'A15' ];
        $csv2 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'B6（', 'B7', 'B8', 'B9（', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];

        $this->assertNull($obj->csvRecord($csv1));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertTrue($obj->getData() != '');
    }
    public function testCsvRecord6()
    {
        $obj = new ZipcodeTransfer;
        $csv1 = [ 'A1', 'A2', 'A3', 'A4', 'A5', 'イカニケイサイガナイバアイ', 'A7', 'A8', '以下に掲載がない場合', 'A10', 'A11', 'A12', '0', 'A14', 'A15' ];
        $csv2 = [ 'B1', 'B2', 'B3', 'B4', 'B5', 'イカニケイサイガナイバアイ', 'B7', 'B8', '以下に掲載がない場合', 'B10', 'B11', 'B12', '0', 'B14', 'B15' ];

        $this->assertNull($obj->csvRecord($csv1));
        $this->assertNull($obj->csvRecord($csv2));
        $this->assertTrue($obj->getData() != '');
    }
}
