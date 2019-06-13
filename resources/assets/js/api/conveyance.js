const CONVEYANCE_API = 'http://localhost:8081/api/conveyance/';

export default {

    /**
     * 上下架处理
     * @param conveyanceId
     * @returns {*}
     */
    updateUsedStatus: function(conveyanceId) {
        return axios.post(CONVEYANCE_API + 'updateUsedStatus', {
            conveyanceId: conveyanceId
        });
    },

    /**
     * 创建运输资源
     * @param conveyance
     * @returns {*}
     */
    createConveyance: function (conveyance, conveyanceImage) {
        return axios.post(CONVEYANCE_API + 'createConveyance', {
            conveyance: conveyance,
            conveyanceImage: conveyanceImage
        });
    },

    /**
     * 修改运输资源
     * @param conveyance
     * @param conveyanceImage
     * @returns {*}
     */
    updateConveyance: function(conveyance, conveyanceImage) {
        return axios.post(CONVEYANCE_API + 'updateConveyance', {
            conveyance: conveyance,
            conveyanceImage: conveyanceImage
        });
    },

    /**
     * 删除文件
     * @param fileName
     * @returns {*}
     */
    deleteFile: function (fileName) {
        return axios.post(CONVEYANCE_API + 'deleteFile', {
            fileName: fileName
        });
    },

    /**
     * 获取数据
     * @returns {*}
     */
    getData: function (condition) {
        return axios.post(CONVEYANCE_API + 'getData', {
            condition: condition
        });
    },

    /**
     * 获取用户发布的资源数据
     * @param userId
     */
    getDataByUserId: function(userId) {
        return axios.get(CONVEYANCE_API + 'getDataByUserId/' + userId);
    },

    /**
     * 获取选择数据
     * @returns {*}
     */
    getSelectData: function () {
        return axios.get(CONVEYANCE_API + 'getSelectData');
    },

    /**
     * 获取运输资源订单信息
     * @param conveyanceId
     * @returns {*}
     */
    getConveyanceOrderInfo: function (conveyanceId) {
        return axios.get(CONVEYANCE_API + 'getConveyanceOrderInfo/' + conveyanceId);
    },
    /**
     * 获取详细信息
     * @param conveyanceId
     * @returns {*}
     */
    getInfo: function (conveyanceId) {
        return axios.get(CONVEYANCE_API +  conveyanceId);
    },

    /**
     * 获取运输资源，管理员
     * @returns {*}
     */
    getConveyanceDataAdmin: function () {
        return axios.get(CONVEYANCE_API + 'getConveyanceDataAdmin');
    },
    /**
     * 获取运输订单数据，管理员
     * @returns {*}
     */
    getConveyanceOrderDataAdmin: function () {
        return axios.get(CONVEYANCE_API + 'getConveyanceOrderDataAdmin');
    },

    /**
     * 审核通过
     * @param conveyanceId
     * @returns {*}
     */
    passConveyance: function (conveyanceId) {
        return axios.post(CONVEYANCE_API + 'passConveyance', {
            conveyanceId: conveyanceId
        });
    },
    /**
     * 审核不通过
     * @param conveyanceId
     * @returns {*}
     */
    rejectConveyance: function (conveyanceId) {
        return axios.post(CONVEYANCE_API + 'rejectConveyance', {
            conveyanceId: conveyanceId
        });
    }
}