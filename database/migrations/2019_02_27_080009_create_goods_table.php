<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('goodId');
            $table->integer('userId')->reference('userId')->on('user');
            $table->string('province', 50); // 省份
            $table->string('city', 50); // 城市
            $table->string('region', 50); // 地区
            $table->string('address', 225); // 地址
            $table->string('company', 20)->nullable(); // 公司
            $table->integer('area'); // 需要面积
            $table->float('weight', 8, 2); // 货物重量
            $table->dateTime('startTime'); // 开始时间
            $table->dateTime('endTime'); // 结束时间
            $table->float('price', 8,2); // 价格
            $table->string('goodsImage', 225); // 货物图片
            $table->char('usedStatus',1)->default(1); // 使用状态，0表示正常物品，1表示不正常物品
            $table->char('checkedStatus', 1)->default(0); // 0表示未审核，1表示审核通过，-1表示审核未通过
            $table->dateTime('checkedTime')->nullable(); // 审核时间
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
        Schema::dropIfExists('goods');
    }
}
