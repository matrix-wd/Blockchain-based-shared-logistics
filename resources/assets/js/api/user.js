const USER_API = 'http://localhost:8081/api/user/';

export default {
    /**
     * 通过手机号和密码登录
     * @param telephone
     * @param password
     * @returns {*}
     */
    loginPassword: function (telephone, password, rememberPassword) {
        return axios.post(USER_API + 'loginPassword', {
            telephone: telephone,
            password: password,
            rememberPassword: rememberPassword
        });
    },

    /**
     * 短信验证码登录
     * @param telephone
     * @param userAuthCode
     * @param userInfoCode
     * @param rememberPassword
     * @returns {*}
     */
    loginTelephone: function(telephone, authCode, infoCode, rememberPassword) {
        return axios.post(USER_API + 'loginTelephone', {
            telephone: telephone,
            authCode: authCode,
            infoCode: infoCode,
            rememberPassword: rememberPassword
        });
    },

    /**
     * 当前登录状态
     */
    loginStatus: function () {
        return axios.get(USER_API + 'loginStatus');
    },

    /**
     * 退出
     */
    logout: function () {
        return axios.post(USER_API + 'logout');
    },

    /**
     * 获取验证码
     * @returns {*}
     */
    getAuthCode: function () {
        return axios.get(USER_API + 'authCode');
    },

    /**
     * 获取短信验证码
     */
    getInfoCode: function (telephone) {
        return axios.post(USER_API + 'infoCode', {
            telephone: telephone
        });
    },

    /**
     * 修改密码
     * @param telephone
     * @param authCode
     * @param infoCode
     * @param password
     * @returns {*}
     */
    updatePassword: function (telephone, authCode, infoCode, password) {
        return axios.post(USER_API + 'updatePassword', {
            telephone: telephone,
            authCode: authCode,
            infoCode: infoCode,
            password: password
        });
    },

    /**
     * 注册
     * @param telephone
     * @param authCode
     * @param infoCode
     * @param password
     * @returns {*}
     */
    register: function (telephone, authCode, infoCode, password) {
        return axios.post(USER_API + 'register', {
            telephone: telephone,
            authCode: authCode,
            infoCode: infoCode,
            password: password
        });
    },

    /**
     * 修改信息
     */
    updateInfo: function (user) {
        return axios.post(USER_API + 'updateInfo', {
            user: user
        });
    },
    /**
     * 修改密码
     * @returns {*}
     */
    updatePasswordAfterLogin: function (userId, password) {
        return axios.post(USER_API + 'updatePasswordAfterLogin', {
            userId: userId,
            password: password
        });
    },


    /**
     * 获取关注的数据
     * @param userId
     * @param type
     * @returns {*}
     */
    getAttentionData: function (userId, type) {
        return axios.get(USER_API + 'getAttentionData/' + userId + '/' + type);
    },

    /**
     * 获取仓储订单数据
     * @param userId
     * @returns {*}
     */
    getWarehouseOrderData: function (userId) {
        return axios.get(USER_API + 'getWarehouseOrderData/' + userId);
    },

    /**
     * 获取运输订单数据
     * @param userId
     * @returns {*}
     */
    getConveyanceOrderData: function (userId) {
        return axios.get(USER_API + 'getConveyanceOrderData/' + userId);
    },

    /**
     * 获取仓储订单租用信息
     * @param userId
     * @returns {*}
     */
    getWarehouseRentData: function(userId) {
        return axios.get(USER_API + 'getWarehouseRentData/' + userId);
    },

    /**
     * 获取运输订单租用信息
     * @param userId
     * @returns {*}
     */
    getConveyanceRentData: function(userId) {
        return axios.get(USER_API + 'getConveyanceRentData/' + userId);
    },


    /**
     * 获取用户信息完善程度
     */
    getUserInfoStatus: function (userId) {
        return axios.get(USER_API + 'getUserInfoStatus/' + userId);
    },

    /**
     * 获取用户数据 管理员
     * @returns {*}
     */
    getUserDataAdmin: function () {
        return axios.get(USER_API + 'getUserDataAdmin');
    },

    /**
     * 获取区块链地址
     * @param userId
     * @returns {*}
     */
    getBlockAddress: function (userId) {
        return axios.get(USER_API + 'getBlockAddress/' + userId);
    }
}