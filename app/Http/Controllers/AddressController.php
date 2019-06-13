<?php

namespace App\Http\Controllers;

use App\Http\Controllers\common\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取省份信息
     */
    public function getProvince() {
        $province = Address::getProvince();
        return response()->json([
            'errCode' => 0,
            'data' => $province
        ]);
    }



    /**
     * @param $provinceCode
     * @return \Illuminate\Http\JsonResponse
     * 获取城市信息
     */
    public function getCity($provinceCode) {
        $city = Address::getCity($provinceCode);
        return response()->json([
            'errCode' => 0,
            'data' => $city
        ]);
    }

    /**
     * @param $provinceCode
     * @return \Illuminate\Http\JsonResponse
     * 获取乡镇信息
     */
    public function getCountry($cityCode) {
        $country = Address::getCountry($cityCode);
        return response()->json([
            'errCode' => 0,
            'data' => $country
        ]);
    }


    public function executeSql(Request $request) {

        $array = array(
            '0820346b4783437a824561eb3f70ccfe.jpg',
            '2091840510f24778bacbcd0364adfc95.jpeg',
            '60dc31dbc08449098834e6f591aeb915.jpg',
            '677363.jpg',
            '8ef4b8f67a654357b61b2d2cf2023c73.jpg',
            'c57f35705927474faea720e2125d9082.jpg',
            '0b35a0b47c5a48f286ce61c5d374571a.jpg',
            '2981a8c440d64831bbc49973ac2da015.jpg',
            '655117.jpg',
            '707223.jpg',
            'a06c27fc5ea04716bc1e3b3e538a8e57.jpg',
            'e716ee0d09f94363b11209e58801dc70.jpg',
            '0f159dd011314334b840eb42041af5a5.jpg',
            '49f11323bc3e4b928c9497430b0d224a.jpg',
            '667765.jpg',
            '709173.jpg',
            'abc93bed885c4c50aa414958db249104.jpg',
            'e9dad2ce4b754871874c99fcc3eba3dd.jpg',
            '0fcb13475c4c45079e8482213965a30a.jpg',
            '574453.jpg',
            '669119.jpg',
            '724858.jpg',
            'b46e5a0596bf48e08cb79097a8e3f6c8.jpg',
            'ebe96316a50b4f0683094e87a9e24401.jpg',
            '1fed76518bb444c2a14eee443c035c0c.jpg',
            '600787.jpg',
            '66912709aa9f44b8b2d764b25a699f3e.jpg',
            '75e6508cb71141d9b0e498a697c140e1.jpg',
            'c22a2522a361467db515db5702c5b33f.jpg',
        );
        for($i = 1; $i <= count($array); $i++) {
            DB::update("update conveyance set imagePath = '$array[$i]' where conveyanceId = $i");
        }

    }
}
//
//$array = array(
//    '可存放家电、资料，食品、五金建材、家具等物资。库房有水电、消防。欢迎电话咨询，预约看厂房。',
//    '大型仓库便宜出租，无拆迁风险，欢迎考察!',
//    '本项目位于洞泾工业区，周边商业街配套，饭店、住宅、酒店、公寓、公交等，镇政府旁边。目前为期房，可接受意向协议，不收取费用，6月份定房，有意向的企业可以实地考察，详细了解。',
//
//);

//for($i = 1; $i <= 50; $i++) {
//    $company = $res[$i]->CustomerName;
//    $address = $res[$i]->Address;
//    $data = explode('-', $province = $res[$i]->Province_City);
//    $province = $data[0];
//    $city = $data[1];
//    $country = $data[2];
//    $sql = "update warehouse set
//                        company = '$company',
//                        address = '$address',
//                        province = '$province',
//                        city = '$city',
//                        country = '$country' where warehouseId = $i";
//    DB::update($sql);
//}

