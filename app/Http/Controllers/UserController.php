<?php

namespace App\Http\Controllers;


use App\Conveyance;
use App\Warehouse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\common\Address;

class UserController extends Controller
{

    /**
     * @param $userId
     * @return mixed
     * 获取用户信息
     */
    public function index($userId = null) {
        if($userId == null) {
            return response()->json([
                'errCode' => 0,
                'data' => User::all()
            ]);
        }
        return response()->json([
            'errCode' => 0,
            'data' => User::find($userId)
        ]);
    }


    public function getUserDataAdmin() {
        $res = User::all();
        return response()->json([
            'errCode' => 0,
            'data' => $res
        ]);
    }


    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * 获取用户信息
     */
    public function getUserInfoStatus($userId) {
        $infoStatus = User::find($userId, ['infoStatus'])->infoStatus;
        return response()->json([
            'errCode' => 0,
            'data' => $infoStatus
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 注册
     */
    public function register(Request $request) {
        $result = $this->checkAuthCodeAndInfoCode($request);
        if($result != '') {
            return response()->json([
                'errCode' => -1,
                'data' => $result
            ]);
        }
        if($this->is_user_exists($request->input('telephone'))) {
            return response()->json([
                'errCode' => -1,
                'data' => User::USER_EXSITS
            ]);
        }
        $user = User::create([
            'password' => $request->input('password'),
            'telephone' => $request->input('telephone'),
            'lastLoginIp' => $request->getClientIp(),
            'lastLoginTime' => date('Y-m-d H:m:s')
        ]);
        if($user) {
            $request->session()->put('user', $user);
            return response()->json([
                'errCode' => 0,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => User::REGISTE_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改密码
     */
    public function updatePasswordAfterLogin(Request $request) {
        $password = $request->input('password');
        $user = User::where([
            'userId' => $request->input('userId'),
            'password' => $password['old']
        ])->first();
        if($user) {
            $updated_array = array(
                'password' => $password['new']
            );
            $res = User::where('userId', $request->input('userId'))->update($updated_array);
            if($res) {
                return response()->json([
                    'errCode' => 0,
                    'data' => ''
                ]);
            }
            return response()->json([
                'errCode' => -1,
                'data' => User::UPDATED_PASSWORD_FAIL
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => User::OLD_PASSWORD_ERROR
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改信息
     */
    public function updateInfo(Request $request) {
        $user = $request->input('user');
        $province = Address::getProvinceNameByCode($user['province']);
        $city = Address::getCityNameByCode($user['city']);
        $updated_array = array(
            'username' => $user['username'],
            'gender' => $user['gender'],
            'idCard' => $user['idCard'],
            'blockChainAddress' => $user['blockChainAddress'],
            'province' => $province,
            'city' => $city,
            'country' => $user['country'],
            'address' => $user['address'],
            'infoStatus' => 1
        );
        $res = User::where('userId', $user['userId'])->update($updated_array);
        if($res) {
            User::where('userId', $user['userId'])->update([
                'infoStatus' => 1
            ]);
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
        return response()->json([
            'errCode' => -1,
            'data' => User::UPDATED_INFO_FAIL
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     * 用户通过密码登录
     * 登录成功修改最后一次登录ip,最后一次登录时间,登录次数
     */
    public function loginPassword(Request $request) {
        $user = User::where([
            'telephone' => $request->input('telephone'),
            'password' => $request->input('password')
        ])->first();
        if($user) {
            $request->session()->put('user', $user);
            $this->updateLoginInfo($request, $user);
            if($request->input('rememberPassword')) {
                $rememberToken = encrypt($user->userId, User::ENCRYPT_KEY);
                return response()->json([
                        'errCode' => 0,
                        'data' => $user
                    ]
                )->withCookie('rememberToken', $rememberToken, 60 * 24 * 7);
            } else {
                return response()->json([
                    'errCode' => 0,
                    'data' => $user
                ]);
            }
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => User::USER_LOGIN_FAIL
            ]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 使用验证码登录
     */
    public function loginTelephone(Request $request) {
        if(!$this->is_user_exists($request->input('telephone'))) {
            return response()->json([
                'errCode' => -1,
                'data' => User::USER_NOT_EXSITS
            ]);
        }
        $result = $this->checkAuthCodeAndInfoCode($request);
        if($result != '') {
            return response()->json([
                'errCode' => -1,
                'data' => $result
            ]);
        }
        $user = User::where('telephone', $request->input('telephone'))->first();
        $request->session()->put('user', $user);
        $this->updateLoginInfo($request, $user);
        if($request->input('rememberPassword')) {
            $rememberToken = encrypt($user->userId, User::ENCRYPT_KEY);
            return response()->json([
                    'errCode' => 0,
                    'data' => $user
                ]
            )->withCookie('rememberToken', $rememberToken, 60 * 24 * 7);
        } else {
            return response()->json([
                'errCode' => 0,
                'data' => $user
            ]);
        }
    }

    /**
     * 获取用户当前登录状态
     */
    public function loginStatus(Request $request) {
        /**
         * 会话还没过期
         */
        if($request->session()->has('user')) {
            return response()->json([
                'errCode' => 0,
                'data' => $request->session()->get('user')
            ]);
        }
        /**
         * 会话已经过期，但是cookie还在
         */
        if($request->cookie('rememberToken')) {
            $userId = decrypt($request->cookie('rememberToken'), User::ENCRYPT_KEY);
            $user = User::find($userId);
            $this->updateLoginInfo($request, $user);
            $request->session()->put('user', $user);
            return response()->json([
                'errCode' => 0,
                'data' => $user
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
        $request->session()->forget('user');
        $cookie = Cookie::forget('rememberToken');
        return response()->json([
            'errCode' => 0,
            'data' => ''
        ])->withCookie($cookie);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 获取验证码
     */
    public function getAuthCode(Request $request) {
        $authCode = rand(1000, 9999);
        $request->session()->put('authCode', $authCode);
        return response()->json([
            'errCode' => 0,
            'data' => $authCode,
            'data2' => $request->session()->get('authCode')
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取短信验证码
     */
    public function getInfoCode(Request $request) {
        //$infoCode = 1234;
        $infoCode = rand(1000, 9999);
        $telephone = $request->input('telephone');
        $url = "http://www.boyalibrary.com/auth_code.php?phone_number=$telephone&auth_code=$infoCode";
        $result = file_get_contents($url);
        if($result !== '获取验证码成功') {
            return response()->json([
                'errCode' => -1,
                'data' => User::AUTO_INFO_GET_FAIL
            ]);
        }
        $request->session()->put('infoCode', $infoCode);
        $request->session()->put('telephone', $request->input('telephone'));
        return response()->json([
            'errCode' => 0,
            'data' => ''
        ]);
    }


    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * 获取区块链地址
     */
    public function getBlockAddress($userId) {
        $blockAddress = User::find($userId, ['blockChainAddress'])->blockChainAddress;
        return response()->json([
            'errCode' => 0,
            'data' => $blockAddress
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改密码
     */
    public function updatePassword(Request $request) {
        if(!$this->is_user_exists($request->input('telephone'))) {
            return response()->json([
                'errCode' => -1,
                'data' => User::USER_NOT_EXSITS
            ]);
        }
        $result = $this->checkAuthCodeAndInfoCode($request);
        if($result != '') {
            return response()->json([
                'errCode' => -1,
                'data' => $result
            ]);
        }
        User::where('telephone', $request->input('telephone'))->update([
            'password' => $request->input('password')
        ]);
        return response()->json([
            'errCode' => 0,
            'data' => ''
        ]);
    }


    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * 获取关注的资源
     */
    public function getAttentionData($userId, $type) {
        $allow_type = ['warehouse', 'conveyance'];
        if(in_array($type, $allow_type)) {
            $data = User::find($userId)
                ->resource($type)
                ->where('attention.type', $type)
                ->get();
            return response()->json([
                'errCode' => 0,
                'data' => $data
            ]);
        }
        return response()->json([
            'errCode' => -1,
            'data' => User::REQUEST_ILLEAGAL
        ]);
    }


    /**
     * @param $userId
     * @return mixed
     * 获取仓储订单资源
     */
    public function getWarehouseOrderData($userId) {
        $result = Warehouse::leftJoin('warehouseOrder', 'warehouseOrder.resourceId', '=', 'warehouse.warehouseId')
            ->where('warehouseOrder.userId', '=', $userId)
            ->orderBy('warehouseOrder.created_at', 'desc')
            ->get(['warehouse.title', 'warehouse.imagePath' ,'warehouse.category', 'warehouse.userId',
                'warehouse.province', 'warehouse.city', 'warehouse.country', 'warehouse.address',
                'warehouseOrder.area', 'warehouseOrder.price', 'warehouse.warehouseId',
                'warehouseOrder.orderId', 'warehouseOrder.replyContent',
                'warehouseOrder.startDate','warehouseOrder.endDate', 'warehouseOrder.content',
                'warehouseOrder.status', 'warehouseOrder.amount', 'warehouseOrder.created_at']);
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * @param $userId
     * @return mixed
     * 获取运输订单资源
     */
    public function getConveyanceOrderData($userId) {
        $result = Conveyance::leftJoin('conveyanceOrder', 'conveyanceOrder.resourceId', '=', 'conveyance.conveyanceId')
            ->where('conveyanceOrder.userId', '=', $userId)
            ->orderBy('conveyanceOrder.created_at', 'desc')
            ->get(['conveyance.title', 'conveyance.imagePath', 'conveyance.category', 'conveyance.userId',
                'conveyanceOrder.area', 'conveyanceOrder.price', 'conveyance.conveyanceId',
                'conveyanceOrder.orderId', 'conveyanceOrder.replyContent',
                'conveyanceOrder.province', 'conveyanceOrder.city', 'conveyanceOrder.country',
                'conveyanceOrder.address', 'conveyanceOrder.content', 'conveyanceOrder.distance',
                'conveyanceOrder.status', 'conveyanceOrder.amount', 'conveyanceOrder.created_at']);
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }


    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * 获取仓储资源出租数据
     */
    public function getWarehouseRentData($userId) {
        $result = Warehouse::leftJoin('warehouseOrder', 'warehouseOrder.resourceId', '=', 'warehouse.warehouseId')
            ->where('warehouse.userId', '=', $userId)
            ->orderBy('warehouseOrder.created_at', 'desc')
            ->get(['warehouse.title', 'warehouse.imagePath', 'warehouse.category',
                'warehouse.province', 'warehouse.city', 'warehouse.country', 'warehouse.address',
                'warehouseOrder.orderId', 'warehouseOrder.replyContent',
                'warehouseOrder.area', 'warehouseOrder.price', 'warehouse.warehouseId',
                'warehouseOrder.startDate','warehouseOrder.endDate', 'warehouseOrder.content',
                'warehouseOrder.status', 'warehouseOrder.amount', 'warehouseOrder.created_at']);
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     * 获取运输资源出租数据
     */
    public function getConveyanceRentData($userId) {
        $result = User::leftJoin('conveyanceOrder', 'conveyanceOrder.userId', '=', 'user.userId')
            ->join('conveyance', function($join) use ($userId) {
                $join->on('conveyance.conveyanceId', '=', 'conveyanceOrder.resourceId')
                ->where('conveyance.userId', '=', $userId);
            })->orderBy('conveyanceOrder.created_at', 'desc')
            ->get(['conveyance.title', 'conveyance.imagePath' ,'conveyance.category',
                'conveyanceOrder.area', 'conveyanceOrder.price', 'conveyance.conveyanceId',
                'conveyanceOrder.orderId', 'conveyanceOrder.replyContent',
                'conveyanceOrder.province', 'conveyanceOrder.city', 'conveyanceOrder.country',
                'conveyanceOrder.address', 'conveyanceOrder.content', 'conveyanceOrder.distance',
                'conveyanceOrder.status', 'conveyanceOrder.amount', 'conveyanceOrder.created_at']);
        return response()->json([
            'errCode' => 0,
            'data' => $result
        ]);
    }


    /**
     * @param $username
     * @return mixed
     * 判断用户是否已经存在
     */
    private function is_user_exists($telephone) {
        return User::where('telephone', $telephone)->first();
    }


    /**
     * @param Request $request
     * @param $user
     * 修改用户登录信息
     */
    private function updateLoginInfo(Request $request, $user) {
        $updated_array = array(
            'lastLoginIp' => $request->getClientIp(),
            'lastLoginTime' => date('Y-m-d H:m:s'),
            'loginTimes' => $user->loginTimes + 1
        );
        User::where('userId', $user->userId)->update($updated_array);
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     * 验证验证码是否正确
     */
    private function checkAuthCodeAndInfoCode(Request $request) {
        $result = '';
        if($request->input('authCode') != $request->session()->get('authCode')) {
            $result = User::AUTH_CODE_ERROR;
        } else if($request->input('infoCode') != $request->session()->get('infoCode')) {
            $result = User::AUTH_INFO_CODE_ERROR;
        }else if($request->input('telephone') != $request->session()->get('telephone')) {
            $result = User::AUTH_CODE_NOT_MATCH_TELEPHONE;
        }
        return $result;
    }


}
