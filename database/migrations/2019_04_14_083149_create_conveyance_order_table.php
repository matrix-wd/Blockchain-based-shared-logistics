<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConveyanceOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conveyanceOrder', function (Blueprint $table) {
            $table->increments('orderId');
            $table->integer('userId')->reference('userId')->on('user');
            $table->integer('resourceId');
            $table->float('price', 8, 2);
            $table->string('province', 50);
            $table->string('city', 50);
            $table->string('country', 50);
            $table->string('address', 255);
            $table->integer('area'); // 面积
            $table->integer('distance'); // 距离
            $table->text('content'); // 内容
            $table->char('status', 2)->default(0); // -1 => 拒绝, 0 => 未审核, 1 => 同意, 2 => 用户支付成功, 3 => 退款 4=> 完成
            $table->text('replyContent')->nullable(); // 回复内容
            $table->float('amount', '8', 2); // 总价格
            $table->integer('score')->default(0); // 评分
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
        Schema::dropIfExists('conveyanceOrder');
    }
}
