const WAREHOUSE_API = 'http://localhost:8081/api/warehouseOrder/';

export default {

    /**
     * 获取订单数据
     * @returns {*}
     */
    getOrderData: function() {
        return axios.get(WAREHOUSE_API + 'getOrderData');
    },

    /**
     * 获取资源出租情况
     * @param warehouseId
     * @returns {*}
     */
    getRentInfo: function(warehouseId) {
        return axios.get(WAREHOUSE_API + 'getRentInfo/' + warehouseId);
    },

    /**
     * 获取管理员数据
     * @returns {*}
     */
    getOrderDataAdmin: function() {
        return axios.get(WAREHOUSE_API + 'getOrderDataAdmin');
    },

    /**
     * 获取推荐数据
     * @param number
     * @returns {*}
     */
    getRecommendData: function(number) {
        return axios.get(WAREHOUSE_API + 'getRecommendData/' + number);
    },

    /**
     * 获取预定数据
     * @returns {*}
     */
    getReserveData: function(resourceId) {
        return axios.get(WAREHOUSE_API + 'getReserveData/' + resourceId);
    },

    /**
     * 预约租用仓储资源
     * @param userId
     * @param warehouseId
     * @param startDate
     * @param endDate
     * @param area
     * @param price
     * @param content
     * @returns {*}
     */
    rentItem: function(userId, warehouseId, startDate, endDate, area, price, content) {
        return axios.post(WAREHOUSE_API + 'rentItem', {
            userId: userId,
            warehouseId: warehouseId,
            startDate: startDate,
            endDate: endDate,
            area: area,
            price: price,
            content: content
        });
    },

    /**
     * 接单
     * @param orderId
     * @returns {*}
     */
    acceptItem: function (orderId) {
        return axios.post(WAREHOUSE_API + 'acceptItem', {
            orderId: orderId
        });
    },

    /**
     * 拒单
     * @param orderId
     * @returns {*}
     */
    rejectItem: function (orderId, replyContent) {
        return axios.post(WAREHOUSE_API + 'rejectItem', {
            orderId: orderId,
            replyContent: replyContent
        });
    },

    /**
     * 支付订单
     * @param orderId
     * @returns {*}
     */
    payItem: function (orderId) {
        return axios.post(WAREHOUSE_API + 'payItem', {
            orderId: orderId
        });
    },

    /**
     * 评价订单
     * @param orderId
     * @param score
     * @returns {*}
     */
    finishItem: function (orderId, score) {
        return axios.post(WAREHOUSE_API + 'finishItem', {
            orderId: orderId,
            score: score
        });
    },

    /**
     * 退款申请
     * @param orderId
     * @param replyContent
     * @returns {*}
     */
    refundItem: function (orderId, replyContent) {
        return axios.post(WAREHOUSE_API + 'refundItem', {
            orderId: orderId,
            replyContent: replyContent
        });
    },

    /**
     * 同意退款
     * @param orderId
     * @returns {*}
     */
    agreeRefund: function (orderId) {
        return axios.post(WAREHOUSE_API + 'agreeRefund', {
            orderId: orderId
        });
    },


    /**
     * 拒绝退款
     * @param orderId
     * @returns {*}
     */
    disagreeRefund: function (orderId) {
        return axios.post(WAREHOUSE_API + 'disagreeRefund', {
            orderId: orderId
        });
    }

}