<?php

namespace App\Http\Controllers;

use App\Conveyance;
use Illuminate\Http\Request;
use App\Http\Controllers\common\Address;
use App\Http\Controllers\common\File;
use Illuminate\Support\Facades\DB;

class ConveyanceController extends Controller
{

    /**
     * @param $conveyanceId
     * @return \Illuminate\Http\JsonResponse
     * 获取详细信息
     */
    public function index($conveyanceId) {
        return response()->json([
            'errCode' => 0,
            'data' => Conveyance::find($conveyanceId)
        ]);
    }

    /**
     * @param $conveyanceId
     * @return \Illuminate\Http\JsonResponse
     * 上下架处理
     */
    public function updateUsedStatus(Request $request) {
        $conveyanceId = $request->input('conveyanceId');
        $usedStatus = Conveyance::find($conveyanceId, ['usedStatus'])->usedStatus;
        if($usedStatus === '0') {
            $usedStatus = '1';
        } else {
            $usedStatus = '0';
        }
        $updated_array = array(
            'usedStatus' => $usedStatus
        );
        $res = Conveyance::where('conveyanceId', $conveyanceId)->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $usedStatus
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::UPDATE_WAREHOUSE_USEDSTATUS_FAIL
            ]);
        }

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取运输资源，管理员
     */
    public function getConveyanceDataAdmin() {
        $res = Conveyance::orderBy('checkedStatus')
            ->get(['conveyanceId', 'title', 'address', 'checkedStatus', 'category', 'price', 'created_at']);
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 通过审核
     */
    public function passConveyance(Request $request) {
        $conveyanceId = $request->input('conveyanceId');
        $updated_array = array(
            'checkedStatus' => '1',
            'checkedTime' => date('Y-m-d H:i:s')
        );
        $res = Conveyance::where('conveyanceId', $conveyanceId)->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::UPDATE_CONVEYANCE_FAIL
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 审核不通过
     */
    public function rejectConveyance(Request $request) {
        $conveyanceId = $request->input('conveyanceId');
        $updated_array = array(
            'checkedStatus' => '-1',
            'checkedTime' => date('Y-m-d H:i:s')
        );
        $res = Conveyance::where('conveyanceId', $conveyanceId)->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::UPDATE_CONVEYANCE_FAIL
            ]);
        }
    }


    /**
     * @param $conveyanceId
     * @return \Illuminate\Http\JsonResponse
     * 获取交易信息
     */
    public function getConveyanceOrderInfo($conveyanceId) {
        return response()->json([
            'errCode' => 0,
            'data' => Conveyance::find($conveyanceId)
                ->orderUsers()
                ->get(['telephone'])
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取数据
     */
    public function getData(Request $request) {
        $condition =  $request->input('condition');
        $orderData = $condition['orderData'];
        $method = $condition['method'];
        $searchData = $condition['searchData'];
        $result = Conveyance::where('checkedStatus', 1)
            ->where('usedStatus', '=', '1')
            ->where(function($query) use ($searchData) {
                $query->where('title', 'like', '%'.$searchData.'%')
                    ->orWhere('description', 'like', '%'.$searchData.'%');
            })->whereBetween('price', [$condition['price'][0], $condition['price'][1]])
            ->whereBetween('length', [$condition['length'][0], $condition['length'][1]])
            ->whereBetween('width', [$condition['width'][0], $condition['length'][1]])
            ->whereBetween('height', [$condition['height'][0], $condition['height'][1]])
            ->whereBetween('maxWeight', [$condition['maxWeight'][0], $condition['maxWeight'][1]])
            ->whereIn('category', $condition['category'])
            ->whereIn('type', $condition['type'])
            ->orderBy($orderData, $method)
            ->get();
        return response()->json([
            'errCode' => 0,
            'data' => $result,
        ]);
    }

    /**
     * @param $userid
     * @return \Illuminate\Http\JsonResponse
     * 获取用户发布的数据
     */
    public function getDataByUserId($userid) {
        $data = Conveyance::where('userId', $userid)->get();
        return response()->json([
            'errCode' => 0,
            'data' => $data
        ]);
    }


    /***
     * 获取选择数据
     */
    public function getSelectData() {
        $maxPrice = Conveyance::max('price');
        $maxLength = Conveyance::max('length');
        $maxWidth = Conveyance::max('width');
        $maxHeight = Conveyance::max('height');
        $maxWeight = Conveyance::max('maxWeight');
        return [
            'errCode' => 0,
            'data' => [
                'maxPrice' => $maxPrice,
                'maxLength' => $maxLength,
                'maxWidth' => $maxWidth,
                'maxHeight' => $maxHeight,
                'maxWeight' => $maxWeight
            ]
        ];
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 新增运输资源
     */
    public function createConveyance(Request $request) {
        $conveyanceImage = $request->input('conveyanceImage');
        if($conveyanceImage == '') {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::CONVEYANCE_IMAGE_NOT_FOUNT
            ]);
        }
        $conveyance = $request->input('conveyance');
        $province = Address::getProvinceNameByCode($conveyance['province']);
        $city = Address::getCityNameByCode($conveyance['city']);
        $userId = $request->session()->get('user')->userId;
        $res = Conveyance::create([
            'userId' => $userId,
            'title' => $conveyance['title'],
            'province' => $province,
            'city' => $city,
            'country' => $conveyance['country'],
            'address' => $conveyance['address'],
            'price' => $conveyance['price'],
            'category' => $conveyance['category'],
            'company' => $conveyance['company'],
            'description' => $conveyance['description'],
            'length' => $conveyance['length'],
            'width' => $conveyance['width'],
            'height' => $conveyance['height'],
            'number' => $conveyance['number'],
            'maxWeight' => $conveyance['maxWeight'],
            'type' => $conveyance['type'],
            'imagePath' => $conveyanceImage
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::CREATE_CONVEYANCE_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改运输资源信息
     */
    public function updateConveyance(Request $request) {
        $conveyanceImage = $request->input('conveyanceImage');
        if($conveyanceImage == '') {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::CONVEYANCE_IMAGE_NOT_FOUNT
            ]);
        }
        $conveyance = $request->input('conveyance');
        $province = Address::getProvinceNameByCode($conveyance['province']);
        $city = Address::getCityNameByCode($conveyance['city']);
        $updated_array = array(
            'title' => $conveyance['title'],
            'province' => $province,
            'city' => $city,
            'country' => $conveyance['country'],
            'address' => $conveyance['address'],
            'price' => $conveyance['price'],
            'category' => $conveyance['category'],
            'company' => $conveyance['company'],
            'description' => $conveyance['description'],
            'length' => $conveyance['length'],
            'width' => $conveyance['width'],
            'height' => $conveyance['height'],
            'number' => $conveyance['number'],
            'maxWeight' => $conveyance['maxWeight'],
            'type' => $conveyance['type'],
            'imagePath' => $conveyanceImage,
            'checkedStatus' => '0'
        );
        $res = Conveyance::where('conveyanceId', $conveyance['conveyanceId'])->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Conveyance::UPDATE_CONVEYANCE_FAIL
            ]);
        }
    }


    /**
     * @param Request $request
     * @return string
     * 上传文件
     */
    public function uploadFile(Request $request) {
        $storagePath = 'conveyance';
        $allowExtension = ['jpg', 'jpeg', 'png'];
        $res = File::upload($request, $storagePath, $allowExtension);
        if(strpos($res, '/')) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        }
        return response()->json([
            'errCode' => -1,
            'data' => $res
        ]);
    }


    /**
     * @param Request $request
     * @return mixed
     * 删除文件
     */
    public function deleteFile(Request $request) {
        $fileName = $request->input('fileName');
        $res = File::delete($fileName);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => File::DELETE_FILE_FAIL
            ]);
        }
    }
}
