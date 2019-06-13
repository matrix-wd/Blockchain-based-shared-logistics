<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('orderId');
            $table->integer('userId')->reference('userId')->on('user');
            $table->integer('resourceId'); // 仓库id或运输工具id，通过触发器实现依赖
            $table->float('price', 8, 2); // 单价
            $table->date('startDate'); // 开始时间
            $table->date('endDate'); // 结束时间
            $table->integer('area'); // 面积
            $table->float('amount', '8', 2); // 总价格
            $table->integer('rate'); // 评分
            $table->char('type', 10); // warehouse, conveyance
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
        Schema::dropIfExists('orders');
    }
}
