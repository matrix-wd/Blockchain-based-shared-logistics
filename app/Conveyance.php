<?php

namespace App;

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conveyance extends Model
{

    use SoftDeletes;
    /**
     * 改变默认数据
     */
    protected $table = 'conveyance'; // 该模型对应的表
    protected $primaryKey = 'conveyanceId'; // 主键
    protected $guarded = []; // 黑名单属性
    protected $dates = ['deleted_at'];

    protected $appends = ['attentioned'];

    const CREATE_CONVEYANCE_FAIL = '新增运输工具失败';
    const CHECK_CONVEYANCE_FAIL = '审核运输工具失败';
    const UPDATED_USED_STATUS_FAIL = '修改使用权限失败';
    const DELETE_CONVEYANCE_FAIL = '删除运输工具失败';
    const CONVEYANCE_IMAGE_LIMIT = '最多只能上传5张图片';
    const CONVEYANCE_IMAGE_NOT_FOUNT = '请上传图片';
    const UPDATE_CONVEYANCE_FAIL = '修改运输资源失败';
    const UPDATE_WAREHOUSE_USEDSTATUS_FAIL = '处理失败';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 获取是否被用户关注
     */
    public function conveyances($userId) {
        return $this->belongsToMany('App\User', 'attention', 'resourceId', 'userId')
            ->where('attention.type', 'conveyance')
            ->where('attention.userId', $userId);
    }

    /**
     * @return int
     * 是否被用户关注
     */
    public function getAttentionedAttribute() {
        if(session('user')) {
            $user = session('user');
            return $this->conveyances($user->userId)->count();
        }
        return 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 获取历史订单信息
     */
    public function orderUsers() {
        return $this->belongsToMany('App\User','conveyanceOrder', 'resourceId', 'userId')
            ->wherePivot('score', '!=', '0')
            ->withPivot('price', 'area', 'amount', 'score', 'created_at');
    }

    public function orderConveyances() {
        return $this->belongsToMany('App\Conveyance', 'orders','resourceId', 'resourceId')
            ->where('orders.type', 'conveyance')
            ->withPivot('price');
    }

}
