<?php
namespace App;

use Sonar\Common\Imports\CsvReaderTrait;

class ZipcodeTransfer
{
    use CsvReaderTrait;

    private $prev_csv;
    private $data;
    private $counter;

    public function __construct()
    {
        $this->prev_csv = null;
        $this->data = '';
        $this->counter = [];
    }

    public function csvRecord(array $csv)
    {
        if ( isset($this->prev_csv) === false ) {
            $this->prev_csv = $csv;
            return;
        }
        $prev_csv = $this->prev_csv;
        if ( $prev_csv[2] == $csv[2] && $csv[12] == '0' ) {
            foreach([5,8] as $num ) {
                $csv[$num] = $prev_csv[$num] . $csv[$num];
            }
        } else {
            $this->prev_csv = $prev_csv;
            $this->addData();

            $counter = isset($this->counter[$prev_csv[2]]) ? $this->counter[$prev_csv[2]] : 0;
            $counter++;
            $this->counter[$prev_csv[2]] = $counter;
        }
        $this->prev_csv = $csv;
    }
    public function getData()
    {
        if (isset($this->prev_csv)) {
            $this->addData();
        }
        return $this->data;
    }

    private function addData()
    {
        $counter = isset($this->counter[$this->prev_csv[2]]) ? $this->counter[$this->prev_csv[2]] : 0;
        $this->prev_csv[1] = sprintf("%07s%02d",$this->prev_csv[2],$counter);
        foreach ( [3,4,5] as $num ) {
            $this->prev_csv[$num] = str_replace('(','（',mb_convert_kana($this->prev_csv[$num],'KV'));
        }
        foreach ( [5,8] as $num ) {
            if ( mb_strpos($this->prev_csv[$num], '（') ) {
                $this->prev_csv[$num] = mb_substr($this->prev_csv[$num], 0, mb_strpos($this->prev_csv[$num], '（'));
            }
        }
        foreach ( ['イカニケイサイガナイバアイ' => 5,'以下に掲載がない場合' => 8 ] as $key => $num ) {
            if ( preg_match('/' . $key . '/',$this->prev_csv[$num]) ) {
                $this->prev_csv[$num] = preg_replace('/'  . $key . '/','',$this->prev_csv[$num]);
            }
        }
        $this->prev_csv[] = substr($this->prev_csv[0],0,2);
        $this->data .= implode(",",$this->prev_csv) . "\n";
        $this->prev_csv = null;
    }

}
