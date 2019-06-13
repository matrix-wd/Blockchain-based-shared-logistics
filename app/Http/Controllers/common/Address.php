<?php

namespace App\Http\Controllers\common;

use Illuminate\Support\Facades\DB;

class Address
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取省份信息
     */
    public static function getProvince() {
        $province = DB::select('select * from province');
        return $province;
    }

    /**
     * @param $provinceCode
     * @return \Illuminate\Http\JsonResponse
     * 获取城市信息
     */
    public static function getCity($provinceCode) {
        $city = DB::select('select * from city where provinceCode = :provinceCode', [':provinceCode' => $provinceCode]);
        return $city;
    }

    /**
     * @param $provinceCode
     * @return \Illuminate\Http\JsonResponse
     * 获取乡镇信息
     */
    public static function getCountry($cityCode) {
        $country = DB::select('select * from country where cityCode = :cityCode', [':cityCode' => $cityCode]);
        return $country;
    }

    /**
     * @param $code
     * @return mixed
     * 根据编码获取城市名称
     */
    public static function getCityNameByCode($code) {
        if(!preg_match("/^\d*$/", $code)) {
            return $code;
        }
        $res = DB::select('select name from city where code = :code', [':code' => $code]);
        return $res[0]->name;
    }

    /**
     * @param $code
     * @return mixed
     * 根据省份编码获取省份名称
     */
    public static function getProvinceNameByCode($code) {
        if(!preg_match("/^\d*$/", $code)) {
            return $code;
        }
        $res = DB::select('select name from province where code = :code', [':code' => $code]);
        return $res[0]->name;
    }
}
