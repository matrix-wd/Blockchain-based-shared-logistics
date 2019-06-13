<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // 该模型对应的表
    protected $primaryKey = 'orderId'; // 主键
    protected $guarded = []; // 黑名单属性
    //protected $appends = ['area'];


    const RENT_FAIL = '租用失败';
    const AREA_IS_NOT_ENOUGH = '在该时间段面积不足';

    public function orderConveyances() {
        return $this->belongsTo('App\Conveyance', 'resourceId', 'conveyanceId');
    }


    /**
     * @return float|int
     * 计算面积
     */
//    public function getAreaAttribute() {
//        return $this->width * $this->length;
//    }
}
