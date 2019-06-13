<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('userId'); // 用户id
            $table->string('username', 20)->nullable(); // 用户名
            $table->char('password', 64); // 密码sha256加密
            $table->char('gender', 3)->nullable(); // 性别
            $table->string('province', 50)->nullable(); // 省份
            $table->string('city', 50)->nullable(); // 城市
            $table->string('country', 50)->nullable(); // 地区
            $table->string('address', 225)->nullable(); // 地址
            $table->string('idCard', 18)->nullable(); // 身份证号码
            $table->char('telephone', 11); // 手机号码
            //$table->char('type', 1)->default(2); // 类型：1仓储方，2表示货源方，4表示车源方，3表示既是仓储方也是货源方，6表示既是货源方也是车源方，5表示既是仓储方也是车源方，7表示三方都是
            $table->char('infoStatus', 1)->default(0); // 信息是否完善，0表示不完善，1表示完善
            $table->char('usedStatus',1)->default(1); // 0表示被禁止登陆，1表示可以正常使用
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
        Schema::dropIfExists('user');
    }
}

