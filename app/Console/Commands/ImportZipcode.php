<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Chumper\Zipper\Zipper;
use Ixudra\Curl\Builder as Curl;

//use Symfony\Component\Console\Input\InputOption;
use App\ZipcodeTransfer;

class ImportZipcode extends Command
{
    const URL = 'http://www.post.japanpost.jp/zipcode/dl/kogaki/zip/ken_all.zip';

    protected $signature = 'import:zipcode {--file-only} {--import-only} {--url=}';

    private $transfer;
    private $zipper;
    private $curl;
    private $filesystem;

    public function __construct(ZipcodeTransfer $transfer, Zipper $zipper, Curl $curl, Filesystem $filesystem )
    {
        parent::__construct();

        $this->transfer = $transfer;
        $this->zipper = $zipper;
        $this->curl = $curl;
        $this->filesystem = $filesystem;
    }

    public function handle()
    {
        $file = storage_path(implode(DIRECTORY_SEPARATOR,['app','ken_all.csv.new']));
        $url = $this->option('url') ? $this->option('url') : self::URL;

        if ( ! $this->option('import-only') ) {
            $this->getFile($url);
            $this->transfer->csvRead(storage_path(implode(DIRECTORY_SEPARATOR,['app','ken_all.csv.utf8'])));
            $this->filesystem->put($file,$this->transfer->getData());
        }

        if ( ! $this->option('file-only') ) {
            $this->importKenAll($file);
            $this->importPrefecture();
            $this->importCity();
            $this->importZipcode();
        }
    }
    private function getFile($url)
    {
        $path = implode(DIRECTORY_SEPARATOR ,['app','ken_all.zip']);
        $data = $this->curl->to(self::URL)->get();
        $this->filesystem->put(storage_path($path),$data);
        $zip_file = str_replace(base_path() . DIRECTORY_SEPARATOR ,'',storage_path($path));
        $extract_path = str_replace(base_path() . DIRECTORY_SEPARATOR  ,'',storage_path('app'));

        $zip = $this->zipper->make($zip_file);
        $zip->extractTo($extract_path . DIRECTORY_SEPARATOR);
        $zip->close();
    
        $this->filesystem->put(
            storage_path(implode(DIRECTORY_SEPARATOR,['app','ken_all.csv.utf8'])),
            mb_convert_encoding($this->filesystem->get(storage_path(implode(DIRECTORY_SEPARATOR,['app','KEN_ALL.CSV']))),'utf8','cp932')
        );
    }

    private function importKenAll($file)
    {
        $data = $this->filesystem->get($file);
        $db = app('db');
        $db->table('ken_alls')->delete();

        foreach ( explode("\n",$data) as $rec ) {
            $list = str_getcsv($rec);
            if ( count($list) == 16 ) {
                $db->insert('insert into ken_alls (city,id,code,prefecture_kana,city_kana,kana,prefecture_name,city_name,name,flag1,flag2,flag3,flag4,flag5,flag6,prefecture) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',$list);
            }
        }
    }
    private function importPrefecture()
    {
        $db = app('db');
        $select = $db->table('ken_alls')->select(['prefecture','prefecture_name','prefecture_kana'])->groupBy(['prefecture','prefecture_name','prefecture_kana']);
        $bindings =  $select->getBindings();

        $db->table('zipcode_prefectures')->delete();
        $db->insert('insert into zipcode_prefectures (id,name,kana ) ' . $select->toSql(),$bindings);
    }
    private function importCity()
    {
        $db = app('db');
        $select = $db->table('ken_alls')->select(['city','city_name','city_kana','prefecture','prefecture_name'])->groupBy(['city','city_name','city_kana','prefecture','prefecture_name']);
        $bindings =  $select->getBindings();

        $db->table('zipcode_cities')->delete();
        $db->insert('insert into zipcode_cities (id,name,kana,zipcode_prefecture_id,zipcode_prefecture_name ) ' . $select->toSql(),$bindings);
    }
    private function importZipcode()
    {
        $db = app('db');
        $select = $db->table('ken_alls')->select(['id','name','kana','code','prefecture','prefecture_name','city','city_name']);
        $bindings =  $select->getBindings();

        $db->table('zipcodes')->delete();
        $db->insert('insert into zipcodes (id,name,kana,code,zipcode_prefecture_id,zipcode_prefecture_name,zipcode_city_id,zipcode_city_name ) ' . $select->toSql(),$bindings);
    }
}
