<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\common\Address;
use App\Http\Controllers\common\File;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{

    /**
     * @param $warehouseId
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储资源基本信息
     */
    public function index($warehouseId) {
        return response()->json([
            'errCode' => 0,
            'data' => Warehouse::find($warehouseId)
        ]);
    }


    /**
     * @param $warehouseId
     * @return \Illuminate\Http\JsonResponse
     * 修改使用状态
     */
    public function updateUsedStatus(Request $request) {
        $warehouseId = $request->input('warehouseId');
        $usedStatus = Warehouse::find($warehouseId, ['usedStatus'])->usedStatus;
        if($usedStatus === '0') {
            $usedStatus = '1';
        } else {
            $usedStatus = '0';
        }

        $updated_array = array(
            'usedStatus' => $usedStatus
        );
        $res = Warehouse::where('warehouseId', $warehouseId)->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $usedStatus
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::UPDATE_WAREHOUSE_USEDSTATUS_FAIL
            ]);
        }

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储数据 管理员
     */
    public function getWarehouseDataAdmin() {
        $res = Warehouse::orderBy('checkedStatus')
            ->get(['warehouseId', 'title', 'address', 'checkedStatus', 'category', 'price', 'created_at']);
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 审核通过
     */
    public function passWarehouse(Request $request) {
        $warehouseId = $request->input('warehouseId');
        $updated_array = array(
            'checkedStatus' => '1',
            'checkedTime' => date('Y-m-d H:i:s')
        );
        $res = Warehouse::where('warehouseId', $warehouseId)->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::UPDATE_WAREHOUSE_FAIL
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 审核不通过
     */
    public function rejectWarehouse(Request $request) {
        $warehouseId = $request->input('warehouseId');
        $updated_array = array(
            'checkedStatus' => '-1',
            'checkedTime' => date('Y-m-d H:i:s')
        );
        $res = Warehouse::where('warehouseId', $warehouseId)->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::UPDATE_WAREHOUSE_FAIL
            ]);
        }
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储订单资源
     */
    public function getWarehouseOrderDataAdmin() {
        $res = DB::table('warehouse')->leftJoin('orders', 'orders.resourceId', 'warehouse.warehouseId')
            ->where('orders.type', 'warehouse')
            ->select('warehouse.warehouseId',
                'warehouse.title',
                'warehouse.address',
                'warehouse.checkedStatus',
                'warehouse.category',
                'orders.created_at',
                'orders.rate',
                'orders.area',
                'orders.amount',
                'orders.price')
            ->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @param $warehouseId
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储资源交易信息
     */
    public function getWarehouseOrderInfo($warehouseId) {
        return response()->json([
            'errCode' => 0,
            'data' => Warehouse::find($warehouseId)
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
        $environment = '%' . implode('%', $condition['environment']) . '%';
        $result = Warehouse::where('checkedStatus', 1)
            ->where('usedStatus', '=', '1')
            ->where(function($query) use ($searchData) {
                $query->where('title', 'like', '%'.$searchData.'%')
                    ->orWhere('description', 'like', '%'.$searchData.'%');
            })->whereBetween('price', [$condition['price'][0], $condition['price'][1]])
            ->whereBetween('length', [$condition['length'][0], $condition['length'][1]])
            ->whereBetween('width', [$condition['width'][0], $condition['length'][1]])
            ->whereBetween('height', [$condition['height'][0], $condition['height'][1]])
            ->whereIn('category', $condition['category'])
            ->where('environment', 'like', $environment)
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
     * 获取用户发布的资源
     */
    public function getDataByUserId($userid) {
        $data = Warehouse::where('userId', $userid)->get();
        return response()->json([
            'errCode' => 0,
            'data' => $data
        ]);
    }



    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取数据
     */
    public function getDataOrderByArea(Request $request) {
//        $condition =  $request->input('condition');
//        $orderData = 'length * width desc';
//        $method = $condition['method'];
//        $searchData = $condition['searchData'];
//        $result = Warehouse::where('checkedStatus', 1)
//            ->where(function($query) use ($searchData) {
//                $query->where('title', 'like', '%'.$searchData.'%')
//                    ->orWhere('description', 'like', '%'.$searchData.'%');
//            })->whereBetween('price', [$condition['price'][0], $condition['price'][1]])
//            ->whereBetween('length', [$condition['length'][0], $condition['length'][1]])
//            ->whereBetween('width', [$condition['width'][0], $condition['length'][1]])
//            ->whereBetween('height', [$condition['height'][0], $condition['height'][1]])
//            ->whereIn('category', $condition['category'])
//            ->whereIn('environment', $condition['environment'])
//            ->orderByRaw($orderData)
//            ->get();
//        return response()->json([
//            'errCode' => 0,
//            'data' => $result,
//        ]);
    }



    /***
     * 获取选择数据
     */
    public function getSelectData() {
        $maxPrice = Warehouse::max('price');
        $maxLength = Warehouse::max('length');
        $maxWidth = Warehouse::max('width');
        $maxHeight = Warehouse::max('height');
        return [
            'errCode' => 0,
            'data' => [
                'maxPrice' => $maxPrice,
                'maxLength' => $maxLength,
                'maxWidth' => $maxWidth,
                'maxHeight' => $maxHeight
            ]
        ];
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 新增仓储资源
     */
    public function createWarehouse(Request $request) {
        $warehouseImage = $request->input('warehouseImage');
        if($warehouseImage == '') {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::WAREHOUSE_IMG_NUMBER_LIMIT
            ]);
        }
        $warehouse = $request->input('warehouse');
        $province = Address::getProvinceNameByCode($warehouse['province']);
        $city = Address::getCityNameByCode($warehouse['city']);
        $userId = $request->session()->get('user')->userId;
        $res = Warehouse::create([
            'userId' => $userId,
            'title' => $warehouse['title'],
            'province' => $province,
            'city' => $city,
            'country' => $warehouse['country'],
            'address' => $warehouse['address'],
            'price' => $warehouse['price'],
            'category' => $warehouse['category'],
            'company' => $warehouse['company'],
            'description' => $warehouse['description'],
            'environment' => implode($warehouse['environment'],';'),
            'length' => $warehouse['length'],
            'width' => $warehouse['width'],
            'height' => $warehouse['height'],
            'number' => $warehouse['number'],
            'imagePath' => $warehouseImage
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::CREATE_WAREHOUSE_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改运输资源
     */
    public function updateWarehouse(Request $request) {
        $warehouseImage = $request->input('warehouseImage');
        if($warehouseImage == '') {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::WAREHOUSE_IMG_NUMBER_LIMIT
            ]);
        }
        $warehouse = $request->input('warehouse');
        $province = Address::getProvinceNameByCode($warehouse['province']);
        $city = Address::getCityNameByCode($warehouse['city']);
        $updated_array = array(
            'title' => $warehouse['title'],
            'province' => $province,
            'city' => $city,
            'country' => $warehouse['country'],
            'address' => $warehouse['address'],
            'price' => $warehouse['price'],
            'category' => $warehouse['category'],
            'company' => $warehouse['company'],
            'description' => $warehouse['description'],
            'environment' => implode($warehouse['environment'],';'),
            'length' => $warehouse['length'],
            'width' => $warehouse['width'],
            'height' => $warehouse['height'],
            'number' => $warehouse['number'],
            'imagePath' => $warehouseImage,
            'checkedStatus' => '0'
        );
        $res = Warehouse::where('warehouseId', $warehouse['warehouseId'])->update($updated_array);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => $res
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Warehouse::UPDATE_WAREHOUSE_FAIL
            ]);
        }
    }


    /**
     * @param Request $request
     * @return string
     * 上传文件
     */
    public function uploadFile(Request $request) {
        $storagePath = 'warehouse';
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
