<?php

namespace App\Http\Controllers;

use App\Warehouse;
use App\WarehouseOrder;
use Illuminate\Http\Request;

class WarehouseOrderController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取预定数据
     */
    public function getReserveData($resourceId) {
        $result = WarehouseOrder::leftJoin('user', 'WarehouseOrder.userId', '=', 'user.userId')
            ->whereIn('WarehouseOrder.status', ['2', '3', '5'])
            ->where('WarehouseOrder.resourceId', '=', $resourceId)
            ->where('WarehouseOrder.startDate', '>=', date('Y-m-d'))
            ->selectRaw('WarehouseOrder.area, WarehouseOrder.startDate, 
            WarehouseOrder.endDate, user.telephone,
            WarehouseOrder.created_at')
            ->get();

        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取历史订单数据
     */
    public function getOrderData() {
        $result = WarehouseOrder::leftJoin('user', 'WarehouseOrder.userId', '=', 'user.userId')
            ->join('warehouse', function($join) {
                $join->on('warehouse.warehouseId', '=', 'WarehouseOrder.resourceId');
            })->where('WarehouseOrder.status', '=', '6')->selectRaw('warehouse.warehouseId, warehouse.title, 
            warehouse.imagePath, warehouse.price, WarehouseOrder.area, WarehouseOrder.startDate, 
            WarehouseOrder.endDate, user.telephone as buyer, WarehouseOrder.amount, WarehouseOrder.score,
            WarehouseOrder.created_at')
            ->get();

        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * 获取指定资源的出租数据
     */
    public function getRentInfo($warehouseId) {
        $res = WarehouseOrder::leftJoin('user', 'user.userId', 'warehouseOrder.userId')
            ->where('warehouseOrder.resourceId', '=', $warehouseId)
            ->selectRaw(
                'user.telephone, warehouseOrder.resourceId as warehouseId,
                warehouseOrder.startDate, warehouseOrder.endDate, 
                warehouseOrder.price, warehouseOrder.area, warehouseOrder.rentDays, warehouseOrder.amount, 
                warehouseOrder.status, warehouseOrder.created_at, warehouseOrder.replyContent, warehouseOrder.content,
                warehouseOrder.score'
            )->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 管理员查看订单信息
     */
    public function getOrderDataAdmin() {
        $res = WarehouseOrder::leftJoin('user', 'user.userId', 'warehouseOrder.userId')
            ->selectRaw(
                'user.telephone, warehouseOrder.resourceId as warehouseId,
                warehouseOrder.startDate, warehouseOrder.endDate, 
                warehouseOrder.price, warehouseOrder.area, warehouseOrder.rentDays, warehouseOrder.amount, 
                warehouseOrder.status, warehouseOrder.created_at, warehouseOrder.replyContent, warehouseOrder.content,
                warehouseOrder.score'
            )->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @param null $number
     * @return \Illuminate\Http\JsonResponse
     * 获取推荐数据
     */
    public function getRecommendData($number = null) {
        if($number == null) {
            $number = 3;
        }
        $result = WarehouseOrder::join('warehouse', function ($join) {
            $join->on('warehouse.warehouseId', '=', 'warehouseOrder.resourceId');
        })->selectRaw('resourceId, count(resourceId) as num, warehouse.province, warehouse.city, warehouse.price, warehouse.imagePath')->groupBy('resourceId')
            ->orderBy('num', 'desc')->take($number)->get();
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 预约租用
     */
    public function rentItem(Request $request) {
        /**
         * 判断该时间段是否可以租用
         */
        $res = $this->isFull($request);

        if($res != '') {
            return response()->json([
                'errCode' => -1,
                'data' => $res
            ]);
        }
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $rentDays = round((strtotime($endDate) - strtotime($startDate)) / 3600 / 24);
        $amount = $request->input('price') * $request->input('area') * $rentDays;
        $order = WarehouseOrder::create([
            'userId' => $request->input('userId'),
            'resourceId' => $request->input('warehouseId'),
            'price' => $request->input('price'),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'area' => $request->input('area'),
            'amount' => $amount,
            'rentDays' => $rentDays,
            'content' => $request->input('content')
        ]);
        if($order) {
            return response()->json([
                'errCode' => 0,
                'data' => $order
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => WarehouseOrder::RENT_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 接单
     */
    public function acceptItem(Request $request) {
        $orderId = $request->input('orderId');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
             'status' => '1'
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => WarehouseOrder::ACCEPR_ITEM_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 拒单
     */
    public function rejectItem(Request $request) {
        $orderId = $request->input('orderId');
        $replyContent = $request->input('replyContent');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
            'status' => '-1',
            'replyContent' => $replyContent
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => WarehouseOrder::REJECT_ITEM_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 支付订单
     */
    public function payItem(Request $request) {
        $orderId = $request->input('orderId');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
            'status' => '2'
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 结束订单
     */
    public function finishItem(Request $request) {
        $orderId = $request->input('orderId');
        $score = $request->input('score');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
            'status' => '6',
            'score' => $score
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 退款申请
     */
    public function refundItem(Request $request) {
        $orderId = $request->input('orderId');
        $replyContent = $request->input('replyContent');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
            'status' => '3',
            'replyContent' => $replyContent
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 同意退款
     */
    public function agreeRefund(Request $request) {
        $orderId = $request->input('orderId');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
            'status' => '4'
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 拒绝退款
     */
    public function disagreeRefund(Request $request) {
        $orderId = $request->input('orderId');
        $res = WarehouseOrder::where('orderId', $orderId)->update([
            'status' => '5'
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
    }


    /**
     * @return string
     * 该时间段是否可以租用
     *
     */
    private function isFull(Request $request) {
        $warehouseId = $request->input('warehouseId');
        $area = $request->input('area');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $resource = Warehouse::where('warehouseId', $warehouseId)
            ->get(['width', 'length', 'number']);
        $totalNumber =($resource[0]->width) * ($resource[0]->length) * ($resource[0]->number);

        $usedNumber = WarehouseOrder::where('resourceId', $warehouseId)
            ->whereIn('WarehouseOrder.status', ['0', '2', '3', '5'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('startDate', array($startDate, $endDate))
                    ->orWhereBetween('endDate', array($startDate, $endDate));
            })
            ->selectRaw('sum(area) as usedNumber')
            ->get();

        $usedNumber = $usedNumber[0]->usedNumber;

        if(($usedNumber + $area) > $totalNumber) {
            return WarehouseOrder::AREA_IS_NOT_ENOUGH;
        } else {
            return '';
        }
    }
}
