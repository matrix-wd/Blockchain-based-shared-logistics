<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 登录
     */
    public function login(Request $request) {
        $admin = Admin::where([
            'telephone' => $request->input('telephone'),
            'password' => $request->input('password')
        ])->first();
        if($admin) {
            $request->session()->put('admin', $admin);
            $this->updateLoginInfo($request, $admin);
            return response()->json([
                'errCode' => 0,
                'data' => $admin
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Admin::LOGIN_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 用户当前状态
     */
    public function loginStatus(Request $request) {
        /**
         * 会话还没过期
         */
        if($request->session()->has('admin')) {
            return response()->json([
                'errCode' => 0,
                'data' => $request->session()->get('admin')
            ]);
        }
        return response()->json([
            'errCode' => -1,
            'data' => ''
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 退出
     */
    public function logout(Request $request) {
        $request->session()->forget('admin');
        return response()->json([
            'errCode' => 0,
            'data' => ''
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取用户的仪表盘数据
     */
    public function getUserDashboard() {
        $loginData = DB::table('user')
            ->groupBy('left(lastLoginTime, 7)')
            ->selectRaw('left(lastLoginTime, 7), count(*) as number')
            ->get();
        return response()->json([
            'errCode' => 0,
            'loginData' => $loginData
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取订单的仪表盘数据
     */
    public function getWarehouseOrderDashboard() {
        $res = DB::table('warehouseOrder')
            ->selectRaw('left(created_at, 7) as time, count(*) as number')
            ->groupBy('time')
            ->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取运输资源的订单
     */
    public function getConveyanceOrderDashboard() {
        $res = DB::table('conveyanceOrder')
            ->selectRaw('left(created_at, 7) as time, count(*) as number')
            ->groupBy('time')
            ->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 运输资源的仪表盘数据
     */
    public function getConveyanceDashboard() {
        $res = DB::table('conveyance')
            ->selectRaw('left(created_at, 7) as time, count(*) as number')
            ->groupBy('time')
            ->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储资源的仪表盘数据
     */
    public function getWarehouseDashboard() {
        $res = DB::table('warehouse')
            ->selectRaw('left(created_at, 7) as time, count(*) as number')
            ->groupBy('time')
            ->get();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }


    /**
     * @param Request $request
     * @param $admin
     * 修改登录信息
     */
    private function updateLoginInfo(Request $request, $admin) {
        $updated_array = array(
            'lastLoginIp' => $request->getClientIp(),
            'lastLoginTime' => date('Y-m-d H:m:s'),
            'loginTimes' => $admin->loginTimes + 1
        );
        Admin::where('adminId', $admin->adminId)->update($updated_array);
    }
}
