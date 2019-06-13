<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin'; // 该模型对应的表
    protected $primaryKey = 'adminId'; // 主键
    protected $guarded = []; // 黑名单属性

    protected $hidden = ['password']; // 隐藏元素


    const LOGIN_FAIL = '用户名和密码不匹配';

}
