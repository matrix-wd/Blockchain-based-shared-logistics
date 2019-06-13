<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * 人民币和以太币相互转换
     */
    public function RmbToEth(Request $request) {
        if(!$request->session()->has('price_usd')) {
            $this->getPriceUsd($request);
        }
//        else if(($request->session()->get('set_price_usd_date') + 24 * 60 * 60) < time()) {
//            $this->getPriceUsd($request);
//        }
        return response()->json([
            'errCode' => 0,
            'data' => $request->session()->get('price_usd')
        ]);
    }


    /**
     * @return mixed
     * 获取汇率转换数据
     */
    private function getPriceUsd(Request $request) {
        $data = file_get_contents("https://api.coinmarketcap.com/v1/ticker/ethereum/");
        $data = json_decode($data);
//        $request->session()->put('set_price_usd_date', time());
        $request->session()->put('price_usd', $data[0]->price_usd);
    }
}
