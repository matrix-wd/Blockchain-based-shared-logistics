<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user'; // 该模型对应的表
    protected $primaryKey = 'userId'; // 主键
    protected $guarded = []; // 黑名单属性

    protected $hidden = ['password']; // 隐藏元素

    const ENCRYPT_KEY = 'graduate_pass';
    const USER_EXSITS = '该用户已存在';
    const USER_NOT_EXSITS = '该用户不存在';
    const AUTH_CODE_NOT_MATCH_TELEPHONE = '电话号码和验证码不匹配';
    const USER_LOGIN_FAIL = '登录失败，请核对用户名和密码';
    const AUTH_CODE_ERROR = '验证码错误';
    const AUTH_INFO_CODE_ERROR = '短信验证码错误';
    const AUTO_INFO_GET_FAIL = '获取验证码失败';
    const USER_NO_EXSITS = '该用户不存在';
    const UPDATED_INFO_FAIL = '修改信息失败';
    const OLD_PASSWORD_ERROR = '旧密码错误';
    const UPDATED_PASSWORD_FAIL = '修改密码失败';
    const CHECK_USER_FAIL = '审核失败';
    const UPDATED_USED_STATUS_FAIL = '修改使用权限失败';
    const REGISTE_FAIL = '注册失败';
    const REQUEST_ILLEAGAL = '访问非法资源';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 仓储资源
     */
    public function resource($type) {
        if($type == 'warehouse') {
            return $this->belongsToMany('App\Warehouse', 'attention', 'userId', 'resourceId');
        } else if($type == 'conveyance') {
            return $this->belongsToMany('App\Conveyance', 'attention', 'userId', 'resourceId');
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 订单数据
     */
    public function orders() {
        return $this->belongsToMany('App\User', 'orders', 'userId', 'userId')
        ->withPivot('resourceId', 'type');
    }


}
