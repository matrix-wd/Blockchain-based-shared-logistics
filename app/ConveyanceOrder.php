<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConveyanceOrder extends Model
{
    protected $table = 'conveyanceOrder'; // 该模型对应的表
    protected $primaryKey = 'orderId'; // 主键
    protected $guarded = []; // 黑名单属性

    const AREA_IS_NOT_ENOUGH = "在该时间段面积不足";
    const RENT_FAIL = "租用失败";
    const ACCEPR_ITEM_FAIL = "接单失败";
    const REJECT_ITEM_FAIL = "拒单失败";
}
