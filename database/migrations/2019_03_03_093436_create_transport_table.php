<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport', function (Blueprint $table) {
            $table->increments('transportId');
            $table->integer('conveyanceId')->reference('conveyanceId')->on('conveyance');
            $table->string('province', 50); // 省份
            $table->string('city', 50); // 城市
            $table->string('region', 50); // 地区
            $table->string('address', 225); // 地址
            $table->integer('usedArea'); // 已使用面积
            $table->float('price', 8,2); // 价格
            $table->dateTime('startTime'); // 开始时间
            $table->dateTime('endTime'); // 结束时间
            $table->text('description')->nullable(); // 备注说明
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport');
    }
}
