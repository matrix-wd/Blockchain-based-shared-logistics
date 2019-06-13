<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('adminId');
            $table->char('telephone', 11); // 手机号码
            $table->char('password', 128); // 密码sha512加密
            $table->integer('loginTimes')->default(0); // 登录次数
            $table->string('lastLoginIp', 16); // 最后一次登录ip地址
            $table->dateTime('lastLoginTime'); // 最后一次登录时间
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
        Schema::dropIfExists('admin');
    }
}

