<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttention extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attention', function (Blueprint $table) {
            $table->increments('attentionId');
            $table->integer('userId')->reference('userId')->on('user');
            $table->integer('resourceId'); // 运输资源和仓储资源id
            $table->string('type', '10'); // 类型，可以是warehouse，conveyance
            $table->char('changed', 1)->default(0); // 是否有变动
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
        Schema::dropIfExists('attention');
    }
}
