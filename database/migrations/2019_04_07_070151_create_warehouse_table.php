<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->increments('warehouseId');
            $table->integer('userId')->reference('userId')->on('user');
            $table->string('title', 255); // 标题
            $table->string('province', 50); // 省份
            $table->string('city', 50); // 城市
            $table->string('country', 50); // 地区
            $table->string('address', 225); // 详细地址
            $table->float('price', 8,2); // 价格
            $table->string('category', 10); // 是属于公司还是个人
            $table->string('company', 20)->nullable(); // 公司名称
            $table->text('description'); // 描述
            $table->string('environment')->default(''); // 环境状况
            $table->float('length', 8,2); // 长
            $table->float('width', 8, 2); // 宽
            $table->float('height', 8, 2); // 高
            $table->integer('number')->default(1); // 数量
            $table->text('imagePath')->nullable(); // 仓库图片地址
            $table->char('usedStatus',1)->default(1); // 使用状态，可以使用和不可以使用
            $table->char('checkedStatus', 2)->default(0); // 0表示未审核，1表示审核通过，-1表示审核未通过
            $table->dateTime('checkedTime')->nullable(); // 审核时间
            $table->char('status',1)->default(1); // 1表示当前空闲，1表示当前正在使用
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse');
    }
}
