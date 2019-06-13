<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage', function (Blueprint $table) {
            $table->increments('storageId');
            $table->integer('warehouseId')->reference('warehouseId')->on('warehouse');
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
        Schema::dropIfExists('storage');
    }
}
