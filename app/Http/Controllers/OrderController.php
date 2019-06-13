<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 租用
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
        $amount = $request->input('price') * $request->input('area');
        $order = Order::create([
            'userId' => $request->input('userId'),
            'resourceId' => $request->input('id'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'area' => $request->input('area'),
            'amount' => $amount,
            'rate' => 0
        ]);
        if($order) {
            return response()->json([
                'errCode' => 0,
                'data' => $order
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Order::RENT_FAIL
            ]);
        }
    }

    /**
     * @return string
     * 该时间段是否可以租用
     */
    public function isFull(Request $request) {
        $type = $request->input('type');
        $id = $request->input('id');
        $area = $request->input('area');
        $startDate = $request->input('$startDate');
        $endDate = $request->input('endDate');
        if($type == 'warehouse') {
            $resource = DB::table('warehouse')
                ->where('warehouseId', $id)
                ->get(['width', 'height', 'number']);
            $totalNumber =($resource[0]->width) * ($resource[0]->height) * ($resource[0]->number);
        } else if($type == 'conveyance') {
            $resource = DB::table('conveyance')
                ->where('conveyanceId', $id)
                ->get(['width', 'height', 'number']);
            $totalNumber =($resource[0]->width) * ($resource[0]->height) * ($resource[0]->number);
        }
        $usedNumber = Order::where('type', $type)
            ->where('resourceId', $id)
            ->where('startDate', 'between', array($startDate, $endDate))
            ->orWhere('endDate', 'between', array($startDate, $endDate))
            ->selectRaw('sum(area) as usedNumber')
            ->get();
        $usedNumber = $usedNumber[0]->usedNumber;
        if(($usedNumber + $area) > $totalNumber) {
            return Order::AREA_IS_NOT_ENOUGH;
        } else {
            return '';
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储订单资源
     */
    public function getWarehouseOrderData() {
        $result = Order::leftJoin('user', 'orders.userId', '=', 'user.userId')
            ->join('warehouse', function($join) {
                $join->on('warehouse.warehouseId', '=', 'orders.resourceId')
                    ->where('orders.type', '=', 'warehouse');
            })->get(['orders.type',
                'warehouse.warehouseId',
                'warehouse.title',
                'warehouse.description',
                'warehouse.imagePath',
                'orders.created_at',
                'orders.price',
                'orders.area',
                'warehouse.length',
                'warehouse.width',
                'warehouse.height',
                'warehouse.address']);
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取运输订单资源
     */
    public function getConveyanceOrderData() {
        $result = Order::leftJoin('user', 'orders.userId', '=', 'user.userId')
            ->join('conveyance', function($join) {
                $join->on('conveyance.conveyanceId', '=', 'orders.resourceId')
                    ->where('orders.type', '=', 'conveyance');
            })->get(['orders.type',
                'conveyance.conveyanceId',
                'conveyance.title',
                'conveyance.description',
                'conveyance.imagePath',
                'orders.created_at',
                'orders.price',
                'orders.area',
                'conveyance.length',
                'conveyance.width',
                'conveyance.height',
                'conveyance.address']);
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * 获取推荐的仓储数据
     */
    public function getRecommendWarehouseData($number = null) {
        if($number == null) {
            $number = 3;
        }
        $result = Order::join('warehouse', function ($join) {
            $join->on('warehouse.warehouseId', '=', 'orders.resourceId')
                ->where('orders.type', '=', 'warehouse');
        })->selectRaw('resourceId, count(resourceId) as num,warehouse.province, warehouse.city, warehouse.price, warehouse.imagePath')->groupBy('resourceId')
        ->orderBy('num', 'desc')->take($number)->get();
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * 获取推荐的运输数据
     */
    public function getRecommendConveyanceData($number = null) {
        if($number == null) {
            $number = 3;
        }
        $result = Order::join('conveyance', function ($join) {
            $join->on('conveyance.conveyanceId', '=', 'orders.resourceId')
                ->where('orders.type', '=', 'conveyance');
        })->selectRaw('resourceId, count(resourceId) as num, conveyance.province, conveyance.city, conveyance.price, conveyance.imagePath')->groupBy('resourceId')
            ->orderBy('num', 'desc')->take($number)->get();
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 价格估计
     */
    public function calculatePrice(Request $request) {
//        $condition = $request->input('condition');
//        $result = Order::leftJoin('conveyance', 'conveyance.conveyanceId', '=', 'orders.resourceId')
//            ->where('orders.type', '=', 'conveyance')
//            ->get(['province', 'city', 'country', 'length', 'conveyance.type', 'category', 'width', 'height', 'maxWeight', 'orders.price']);
//        foreach ($result as $key => $item) {
//            if($item->province == $condition['province']) {
//
//            }
//            return $item->province;
//        }
//        return response()->json([
//            'errCode' => 0,
//            'data' => $result[0]->province
//        ]);
        return response()->json([
            'errCode' => 0,
            'minPrice' =>  6.32,
            'maxPrice' => 10.98
        ]);
    }
}
