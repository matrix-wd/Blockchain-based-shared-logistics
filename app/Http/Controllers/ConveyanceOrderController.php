<?php

namespace App\Http\Controllers;

use App\Conveyance;
use App\ConveyanceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\common\Address;

class ConveyanceOrderController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取预定数据
     */
    public function getReserveData($resourceId) {
        $result = ConveyanceOrder::leftJoin('user', 'ConveyanceOrder.userId', '=', 'user.userId')
            ->whereIn('ConveyanceOrder.status', ['2', '3', '5'])
            ->where('ConveyanceOrder.resourceId', '=', $resourceId)
            ->selectRaw('ConveyanceOrder.area, ConveyanceOrder.province, 
            ConveyanceOrder.city, ConveyanceOrder.country, user.telephone,
            ConveyanceOrder.created_at')
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
        $result = ConveyanceOrder::leftJoin('user', 'ConveyanceOrder.userId', '=', 'user.userId')
            ->join('conveyance', function($join) {
                $join->on('conveyance.conveyanceId', '=', 'ConveyanceOrder.resourceId');
            })->where('ConveyanceOrder.status', '=', '6')->selectRaw('conveyance.conveyanceId, conveyance.title, 
            conveyance.imagePath, conveyance.price, ConveyanceOrder.area, ConveyanceOrder.province, 
            ConveyanceOrder.city, ConveyanceOrder.country, ConveyanceOrder.address,
            user.telephone as buyer, ConveyanceOrder.amount, ConveyanceOrder.score,
            ConveyanceOrder.created_at')
            ->get();

        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * 获取指定资源的出租数据
     */
    public function getRentInfo($conveyanceId) {
        $res = ConveyanceOrder::leftJoin('user', 'user.userId', 'conveyanceOrder.userId')
            ->where('conveyanceOrder.resourceId', '=', $conveyanceId)
            ->selectRaw(
                'user.telephone, conveyanceOrder.resourceId as conveyanceId,
                concat(conveyanceOrder.province, conveyanceOrder.city, conveyanceOrder.country, conveyanceOrder.address) as address,
                conveyanceOrder.price, conveyanceOrder.area, conveyanceOrder.distance, conveyanceOrder.amount, 
                conveyanceOrder.status, conveyanceOrder.created_at, conveyanceOrder.replyContent, conveyanceOrder.content,
                conveyanceOrder.score'
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
        $res = ConveyanceOrder::leftJoin('user', 'user.userId', 'conveyanceOrder.userId')
            ->selectRaw(
                'user.telephone, conveyanceOrder.resourceId as conveyanceId,
                concat(conveyanceOrder.province, conveyanceOrder.city, conveyanceOrder.country, conveyanceOrder.address) as address,
                conveyanceOrder.price, conveyanceOrder.area, conveyanceOrder.distance, conveyanceOrder.amount, 
                conveyanceOrder.status, conveyanceOrder.created_at, conveyanceOrder.replyContent, conveyanceOrder.content,
                conveyanceOrder.score'
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
        $result = ConveyanceOrder::join('conveyance', function ($join) {
            $join->on('conveyance.conveyanceId', '=', 'ConveyanceOrder.resourceId');
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
        $province = Address::getProvinceNameByCode($request->input('province'));
        $city = Address::getCityNameByCode($request->input('city'));
        $country = $request->input('country');
        $distance = $request->input('distance');
        $amount = $request->input('price') * $request->input('area') * $distance;

        $order = ConveyanceOrder::create([
            'userId' => $request->input('userId'),
            'resourceId' => $request->input('conveyanceId'),
            'price' => $request->input('price'),
            'province' => $province,
            'city' => $city,
            'country' => $country,
            'address' => $request->input('address'),
            'area' => $request->input('area'),
            'amount' => $amount,
            'distance' => $distance,
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
                'data' => ConveyanceOrder::RENT_FAIL
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
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
                'data' => ConveyanceOrder::ACCEPR_ITEM_FAIL
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
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
                'data' => ConveyanceOrder::REJECT_ITEM_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 订单支付
     */
    public function payItem(Request $request) {
        $orderId = $request->input('orderId');
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
        $res = ConveyanceOrder::where('orderId', $orderId)->update([
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
        $conveyanceId = $request->input('conveyanceId');
        $area = $request->input('area');
        $resource = Conveyance::where('conveyanceId', $conveyanceId)
            ->get(['width', 'length']);
        $totalNumber =($resource[0]->width) * ($resource[0]->length);

        $usedNumber = ConveyanceOrder::where('resourceId', $conveyanceId)
            ->whereIn('ConveyanceOrder.status', ['0', '2', '3', '5'])
            ->selectRaw('sum(area) as usedNumber')
            ->get();

        $usedNumber = $usedNumber[0]->usedNumber;

        if(($usedNumber + $area) > $totalNumber) {
            return ConveyanceOrder::AREA_IS_NOT_ENOUGH;
        } else {
            return '';
        }
    }
}
