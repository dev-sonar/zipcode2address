<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravel\Lumen\Application;


class CreateZipcodeTable extends Migration
{
    private $app;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app('db')->getSchemaBuilder();

        $schema->create('zipcode_prefectures',function(Blueprint $table) {
            $table->char('id',2);
            $table->string('name',30);
            $table->string('kana',60);
            $table->timestamps();
        });

        $schema->create('zipcode_cities',function(Blueprint $table) {
            $table->char('id',5);
            $table->char('zipcode_prefecture_id',2);
            $table->string('zipcode_prefecture_name',30);
            $table->string('name',30);
            $table->string('kana',60);
            $table->timestamps();
        });

        $schema->create('zipcodes',function(Blueprint $table) {
            $table->char('id',9);
            $table->string('name',50);
            $table->string('kana',100);
            $table->char('code',7);
            $table->char('zipcode_prefecture_id',2);
            $table->string('zipcode_prefecture_name',30);
            $table->char('zipcode_city_id',5);
            $table->string('zipcode_city_name',30);
            $table->timestamps();
        });

        $schema->create('ken_alls',function(Blueprint $table) {
            $table->char('city',5);
            $table->char('id',9);
            $table->char('code',7);
            $table->string('prefecture_kana',60);
            $table->string('city_kana',60);
            $table->string('kana',200);
            $table->string('prefecture_name',30);
            $table->string('city_name',30);
            $table->string('name',100);
            $table->integer('flag1');
            $table->integer('flag2');
            $table->integer('flag3');
            $table->integer('flag4');
            $table->integer('flag5');
            $table->integer('flag6');
            $table->char('prefecture');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema = app('db')->getSchemaBuilder();
        $schema->drop('zipcodes');
        $schema->drop('zipcode_cities');
        $schema->drop('zipcode_prefectures');
        $schema->drop('ken_alls');
    }
}
