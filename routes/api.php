<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * 不需要登录就可以访问
 */
Route::group([], function(){
    /**
     * 用户相关
     */
    Route::prefix('user')->group(function() {

        /**
         * 使用帐号和密码登录
         */
        Route::post('/loginPassword', 'UserController@loginPassword');

        /**
         * 登录信息
         */
        Route::get('/loginStatus', 'UserController@loginStatus');

        /**
         * 获取短信验证码
         */
        Route::post('/infoCode', 'UserController@getInfoCode');

        /**
         * 获取验证码
         */
        Route::get('/authCode', 'UserController@getAuthCode');


        /**
         * 修改密码
         */
        Route::post('/updatePassword', 'UserController@updatePassword');

        /**
         * 短信验证码登录
         */
        Route::post('/loginTelephone', 'UserController@loginTelephone');

        /**
         * 注册
         */
        Route::post('/register', 'UserController@register');

        /**
         * 获取用户数据 管理员
         */
        Route::get('/getUserDataAdmin', 'UserController@getUserDataAdmin');

    });

    /**
     * 管理员
     */
    Route::prefix('admin')->group(function() {

        /**
         * 使用帐号和密码登录
         */
        Route::post('/login', 'AdminController@login');

        /**
         * 退出
         */
        Route::get('/logout', 'AdminController@logout');

        /**
         * 登录状态
         */
        Route::get('/loginStatus', 'AdminController@loginStatus');

        /**
         * 获取用户的数据
         */
        Route::get('/getUserDashboard', 'AdminController@getUserDashboard');

        /**
         * 获取订单的仪表盘数据
         */
        Route::get('/getOrderDashboard', 'AdminController@getOrderDashboard');


        /**
         * 获取运输资源的仪表盘数据
         */
        Route::get('/getConveyanceDashboard', 'AdminController@getConveyanceDashboard');


        /**
         * 获取仓储资源的仪表盘数据
         */
        Route::get('/getWarehouseDashboard', 'AdminController@getWarehouseDashboard');


        /**
         * 获取仓储资源订单
         */
        Route::get('/getWarehouseOrderDashboard', 'AdminController@getWarehouseOrderDashboard');


        /**
         * 获取运输资源订单
         */
        Route::get('/getConveyanceOrderDashboard', 'AdminController@getConveyanceOrderDashboard');



    });

    /**
     * 地址相关
     */
    Route::prefix('address')->group(function() {

        /**
         * 获取省份
         */
        Route::get('/province', 'AddressController@getProvince');

        /**
         * 获取城市
         */
        Route::get('/city/{provinceCode}', 'AddressController@getCity')->where('provinceCode', '[0-9]+');

        /**
         * 获取乡镇
         */
        Route::get('/country/{cityCode}', 'AddressController@getCountry')->where('cityCode', '[0-9]+');
    });


    /**
     * 运输资源
     */
    Route::prefix('conveyance')->group(function() {

        /**
         * 获取分页数据
         */
        Route::post('/getData', 'ConveyanceController@getData');


        /**
         * 获取某个运输资源交易信息
         */
        Route::get('/getConveyanceOrderInfo/{conveyanceId}', 'ConveyanceController@getConveyanceOrderInfo')->where('conveyanceId', '[0-9]+');


        /**
         * 获取某个运输资源基本信息
         */
        Route::get('/{conveyanceId}', 'ConveyanceController@index')->where('conveyanceId', '[0-9]+');

        /**
         * 审核通过
         */
        Route::post('/passConveyance', 'ConveyanceController@passConveyance');

        /**
         * 审核不通过
         */
        Route::post('/rejectConveyance', 'ConveyanceController@rejectConveyance');

        /**
         * 获取选择数据
         */
        Route::get('/getSelectData', 'ConveyanceController@getSelectData');

        /**
         * 获取运输资源的信息
         */
        Route::get('/getConveyanceDataAdmin', 'ConveyanceController@getConveyanceDataAdmin');

        /**
         * 获取运输资源的订单信息
         */
        Route::get('/getConveyanceOrderDataAdmin', 'ConveyanceController@getConveyanceOrderDataAdmin');
    });

    /**
     * 仓储订单
     */
    Route::prefix('warehouseOrder')->group(function() {

        /**
         * 获取订单数据
         */
        Route::get('/getOrderData', 'WarehouseOrderController@getOrderData');

        /**
         * 推荐数据
         */
        Route::get('/getRecommendData/{number?}', 'WarehouseOrderController@getRecommendData')->where('number', '[0-9]+');

        /**
         * 获取预定数据
         */
        Route::get('/getReserveData/{resourceId}', 'WarehouseOrderController@getReserveData')->where('resourceId', '[0-9]+');

        /**
         * 获取管理员数据
         */
        Route::get('/getOrderDataAdmin', 'WarehouseOrderController@getOrderDataAdmin');


    });


    /**
     * 运输订单
     */
    Route::prefix('conveyanceOrder')->group(function() {
        /**
         * 获取订单数据
         */
        Route::get('/getOrderData', 'ConveyanceOrderController@getOrderData');

        /**
         * 推荐数据
         */
        Route::get('/getRecommendData/{number?}', 'ConveyanceOrderController@getRecommendData')->where('number', '[0-9]+');

        /**
         * 获取预定数据
         */
        Route::get('/getReserveData/{resourceId}', 'ConveyanceOrderController@getReserveData')->where('resourceId', '[0-9]+');

        /**
         * 获取管理员数据
         */
        Route::get('/getOrderDataAdmin', 'ConveyanceOrderController@getOrderDataAdmin');

    });


    /**
     * 仓储资源
     */
    Route::prefix('warehouse')->group(function() {
        /**
         * 获取分页数据
         */
        Route::post('/getData', 'WarehouseController@getData');

        /**
         * 获取某个运输资源交易信息
         */
        Route::get('/getWarehouseOrderInfo/{warehouseId}', 'WarehouseController@getWarehouseOrderInfo')->where('warehouseId', '[0-9]+');


        /**
         * 获取某个运输资源基本信息
         */
        Route::get('/{warehouseId}', 'WarehouseController@index')->where('warehouseId', '[0-9]+');


        /**
         * 获取选择数据
         */
        Route::get('/getSelectData', 'WarehouseController@getSelectData');


        /**
         * 审核通过
         */
        Route::post('/passWarehouse', 'WarehouseController@passWarehouse');

        /**
         * 审核不通过
         */
        Route::post('/rejectWarehouse', 'WarehouseController@rejectWarehouse');


        /**
         * 获取数据根据面积排序
         */
        Route::post('/getDataOrderByArea', 'WarehouseController@getDataOrderByArea');


        /**
         * 获取仓储资源数据
         */
        Route::get('/getWarehouseDataAdmin', 'WarehouseController@getWarehouseDataAdmin');

        /**
         * 获取仓储资源订单数据
         */
        Route::get('/getWarehouseOrderDataAdmin', 'WarehouseController@getWarehouseOrderDataAdmin');

    });


    /**
     * 订单资源
     */
    Route::prefix('orders')->group(function() {
        /**
         * 估价服务
         */
        Route::post('/calculatePrice', 'OrderController@calculatePrice');

        /**
         * 获取用户仓储订单数据
         */
        Route::get('/getWarehouseOrderData', 'OrderController@getWarehouseOrderData');


        /**
         * 获取用户运输订单数据
         */
        Route::get('/getConveyanceOrderData', 'OrderController@getConveyanceOrderData');


        /**
         * 获取仓储推荐数据
         */
        Route::get('/getRecommendWarehouseData/{number?}', 'OrderController@getRecommendWarehouseData')->where('number', '[0-9]+');


        /**
         * 获取运输推荐数据
         */
        Route::get('/getRecommendConveyanceData/{number?}', 'OrderController@getRecommendConveyanceData')->where('number', '[0-9]+');

    });

    /**
     * 工具
     */
    Route::prefix('tools')->group(function() {

        /**
         * 人民币和以太币相互转换
         */
        Route::get('/RmbToEth', 'ToolsController@RmbToEth');
    });


});

/**
 * 需要登录才可以进行的操作
 */
Route::group(['middleware' => ['LoginAuth']], function () {

    /**
     * 用户相关
     */
    Route::prefix('user')->group(function() {

        /**
         * 退出
         */
        Route::post('/logout', 'UserController@logout');

        /**
         * 修改个人信息
         */
        Route::post('/updateInfo', 'UserController@updateInfo');

        /**
         * 修改用户密码
         */
        Route::post('/updatePasswordAfterLogin', 'UserController@updatePasswordAfterLogin');


        /**
         * 获取用户关注数据
         */
        Route::get('/getAttentionData/{userId}/{type}', 'UserController@getAttentionData')->where('userId', '[0-9]+');


        /**
         * 获取用户仓储订单数据
         */
        Route::get('/getWarehouseOrderData/{userId}', 'UserController@getWarehouseOrderData')->where('userId', '[0-9]+');


        /**
         * 获取仓储订单租用数据
         */
        Route::get('/getWarehouseRentData/{userId}', 'UserController@getWarehouseRentData')->where('userId', '[0-9]+');


        /**
         * 获取运输订单租用数据
         */
        Route::get('/getConveyanceRentData/{userId}', 'UserController@getConveyanceRentData')->where('userId', '[0-9]+');

        /**
         * 获取用户运输订单数据
         */
        Route::get('/getConveyanceOrderData/{userId}', 'UserController@getConveyanceOrderData')->where('userId', '[0-9]+');


        /**
         * 获取用户当前信息完善程度
         */
        Route::get('/getUserInfoStatus/{userId}', 'UserController@getUserInfoStatus')->where('userId', '[0-9]+');

        /**
         * 获取区块链地址
         */
        Route::get('/getBlockAddress/{userId}', 'UserController@getBlockAddress')->where('userId', '[0-9]+');

    });

    /**
     * 仓储资源
     */
    Route::prefix('warehouse')->group(function() {

        /**
         * 上下架处理
         */
        Route::post('/updateUsedStatus/', 'WarehouseController@updateUsedStatus');
        /**
         * 创建仓储资源
         */
        Route::post('/createWarehouse', 'WarehouseController@createWarehouse');


        /**
         * 修改仓储资源
         */
        Route::post('/updateWarehouse', 'WarehouseController@updateWarehouse');

        /**
         * 上传文件
         */
        Route::post('/uploadFile', 'WarehouseController@uploadFile');

        /**
         * 获取用户发布的资源
         */
        Route::get('/getDataByUserId/{userId}', 'WarehouseController@getDataByUserId')->where('userId', '[0-9]+');

        /**
         * 删除文件
         */
         Route::post('/deleteFile', 'WarehouseController@deleteFile');
    });


    /**
     * 仓储订单
     */
    Route::prefix('warehouseOrder')->group(function() {

        /**
         * 预约租用仓储资源
         */
        Route::post('/rentItem', 'WarehouseOrderController@rentItem');

        /**
         * 查看资源的出租数据
         */
        Route::get('/getRentInfo/{warehouseId}', 'WarehouseOrderController@getRentInfo')->where('warehouseId', '[0-9]+');

        /**
         * 接单
         */
        Route::post('/acceptItem', 'WarehouseOrderController@acceptItem');

        /**
         * 拒单
         */
        Route::post('/rejectItem', 'WarehouseOrderController@rejectItem');


        /**
         * 支付订单
         */
        Route::post('/payItem', 'WarehouseOrderController@payItem');


        /**
         * 完成订单
         */
        Route::post('/finishItem', 'WarehouseOrderController@finishItem');

        /**
         * 退款申请
         */
        Route::post('/refundItem', 'WarehouseOrderController@refundItem');

        /**
         * 同意退款
         */
        Route::post('/agreeRefund', 'WarehouseOrderController@agreeRefund');


        /**
         * 拒绝退款
         */
        Route::post('/disagreeRefund', 'WarehouseOrderController@disagreeRefund');

    });


    /**
     * 运输订单
     */
    Route::prefix('conveyanceOrder')->group(function() {


        /**
         * 预约租用仓储资源
         */
        Route::post('/rentItem', 'ConveyanceOrderController@rentItem');

        /**
         * 查看资源的出租数据
         */
        Route::get('/getRentInfo/{conveyanceId}', 'ConveyanceOrderController@getRentInfo')->where('conveyanceId', '[0-9]+');

        /**
         * 接单
         */
        Route::post('/acceptItem', 'ConveyanceOrderController@acceptItem');

        /**
         * 拒单
         */
        Route::post('/rejectItem', 'ConveyanceOrderController@rejectItem');

        /**
         * 支付订单
         */
        Route::post('/payItem', 'ConveyanceOrderController@payItem');

        /**
         * 完成订单
         */
        Route::post('/finishItem', 'ConveyanceOrderController@finishItem');

        /**
         * 退款申请
         */
        Route::post('/refundItem', 'ConveyanceOrderController@refundItem');


        /**
         * 同意退款
         */
        Route::post('/agreeRefund', 'ConveyanceOrderController@agreeRefund');


        /**
         * 拒绝退款
         */
        Route::post('/disagreeRefund', 'ConveyanceOrderController@disagreeRefund');


    });


    /**
     * 运输资源
     */
    Route::prefix('conveyance')->group(function() {

        /**
         * 上下架处理
         */
        Route::post('/updateUsedStatus/', 'ConveyanceController@updateUsedStatus');

        /**
         * 创建运输资源
         */
        Route::post('/createConveyance', 'ConveyanceController@createConveyance');


        /**
         * 修改运输资源
         */
        Route::post('/updateConveyance', 'ConveyanceController@updateConveyance');


        /**
         * 获取用户发布的资源
         */
        Route::get('/getDataByUserId/{userId}', 'ConveyanceController@getDataByUserId')->where('userId', '[0-9]+');

        /**
         * 上传文件
         */
        Route::post('/uploadFile', 'ConveyanceController@uploadFile');

        /**
         * 删除文件
         */
        Route::post('/deleteFile', 'ConveyanceController@deleteFile');
    });


    /**
     * 订单资源
     */
    Route::prefix('orders')->group(function() {
        /**
         * 租用
         */
        Route::post('/rentItem', 'OrderController@rentItem');

    });


    /**
     * 取消关注
     */
    Route::prefix('attention')->group(function() {
        /**
         * 获取分页数据
         */
        Route::delete('/{userId}/{resourceId}/{type}', 'AttentionController@cancelAttention')
            ->where('userId', '[0-9]+')
            ->where('resourceId', '[0-9]+');

        /**
         * 新增关注
         */
        Route::post('/addAttention', 'AttentionController@addAttention');

    });


});