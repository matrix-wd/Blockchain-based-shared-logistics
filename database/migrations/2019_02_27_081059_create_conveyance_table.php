<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConveyanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conveyance', function (Blueprint $table) {
            $table->increments('conveyanceId');
            $table->integer('userId')->reference('userId')->on('user');
            $table->string('province', 50); // 省份
            $table->string('city', 50); // 城市
            $table->string('country', 50); // 地区
            $table->string('address', 225); // 地址
            $table->string('category', 10); // 个人还是公司
            $table->string('company', 20)->nullable(); // 公司
            $table->float('length',8,2); // 货箱长度
            $table->float('width',8,2); // 货箱宽度
            $table->float('height', 8,2); // 货箱宽度
            $table->float('price', 8, 2); //价格
            $table->integer('number'); //数量
            $table->string('type', 50); // 车辆类型(小货车，大货车)
            $table->float('maxWeight', 8, 2); // 最大载重
            $table->string('title', 255); // 标题
            $table->text('description'); // 描述
            $table->text('imagePath')->nullable(); // 汽车图片
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
        Schema::dropIfExists('conveyance');
    }
}
