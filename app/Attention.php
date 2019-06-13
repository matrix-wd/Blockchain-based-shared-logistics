<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attention extends Model
{
    /**
     * 软删除
     */
    use SoftDeletes;
    /**
     * 改变默认数据
     */
    protected $table = 'attention'; // 该模型对应的表
    protected $primaryKey = 'attentionId'; // 主键
    protected $guarded = []; // 黑名单属性
    protected $dates = ['deleted_at'];


    const DELETE_FAIL = "取消关注失败";
    const ADD_ATTENTION_FAIL = '关注失败';
}
