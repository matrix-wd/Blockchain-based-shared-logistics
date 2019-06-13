const ADMIN_API = 'http://localhost:8081/api/admin/';

export default {
    /**
     * 登录
     */
    login: function (telephone, password) {
        return axios.post(ADMIN_API + 'login', {
            telephone: telephone,
            password: password
        });
    },

    /**
     * 退出
     * @returns {*}
     */
    logout: function() {
        return axios.get(ADMIN_API + 'logout');
    },

    /**
     * 登录状态
     * @returns {*}
     */
    loginStatus: function() {
        return axios.get(ADMIN_API + 'loginStatus');
    },

    /**
     * 获取用户的仪表盘
     * @returns {*}
     */
    getUserDashboard: function () {
        return axios.get(ADMIN_API + 'getUserDashboard');
    },

    /**
     * 获取仓储订单的仪表盘数据
     * @returns {*}
     */
    getWarehouseOrderDashboard: function () {
        return axios.get(ADMIN_API + 'getWarehouseOrderDashboard');
    },

    /**
     * 获取运输订单的仪表盘数据
     * @returns {*}
     */
    getConveyanceOrderDashboard: function () {
        return axios.get(ADMIN_API + 'getConveyanceOrderDashboard');
    },

    /**
     * 获取仓储资源的仪表盘数据
     * @returns {*}
     */
    getWarehouseDashboard: function () {
        return axios.get(ADMIN_API + 'getWarehouseDashboard');
    },

    /**
     * 获取运输资源的仪表盘数据
     * @returns {*}
     */
    getConveyanceDashboard: function () {
        return axios.get(ADMIN_API + 'getConveyanceDashboard');
    },

}