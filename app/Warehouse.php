<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    // 软删除
    use SoftDeletes;
    /**
     * 改变默认数据
     */
    protected $table = 'warehouse'; // 该模型对应的表
    protected $primaryKey = 'warehouseId'; // 主键
    protected $guarded = []; // 黑名单属性
    protected $dates = ['deleted_at'];
    protected $appends = ['attentioned'];

    const CREATE_WAREHOUSE_FAIL = '新增仓库失败';
    const UPDATED_INFO_FAIL = '修改信息失败';
    const CHECK_WAREHOUSE_FAIL = '审核仓库信息失败';
    const UPDATED_USED_STATUS_FAIL = '修改使用权限失败';
    const DELETE_WAREHOUSE_FAIL = '删除仓库信息失败';
    const WAREHOUSE_IMAGE_NOT_FOUNT = '请上传图片';
    const WAREHOUSE_IMG_NUMBER_LIMIT = '最多只能上传5张图片';
    const UPDATE_WAREHOUSE_FAIL = '修改仓储资源失败';
    const UPDATE_WAREHOUSE_USEDSTATUS_FAIL = '处理失败';


    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 获取关注的仓储资源
     */
    public function warehouses($userId) {
        return $this->belongsToMany('App\User', 'attention', 'resourceId', 'userId')
            ->where('attention.type', 'warehouse')
            ->where('attention.userId', $userId);
    }


    public function getAttentionedAttribute() {
        if(session('user')) {
            $user = session('user');
            return $this->warehouses($user->userId)->count();
        }
        return 0;
    }


    public function orderUsers() {
        return $this->belongsToMany('App\User','warehouseOrder', 'resourceId', 'userId')
            ->wherePivot('score', '!=', '0')
            ->withPivot('price', 'area', 'amount', 'score', 'created_at');
    }

}
