const CONVEYANCE_API = 'http://localhost:8081/api/conveyanceOrder/';

export default {

    /**
     * 获取订单数据
     * @returns {*}
     */
    getOrderData: function() {
        return axios.get(CONVEYANCE_API + 'getOrderData');
    },

    /**
     * 获取资源出租情况
     * @param conveyanceId
     * @returns {*}
     */
    getRentInfo: function(conveyanceId) {
        return axios.get(CONVEYANCE_API + 'getRentInfo/' + conveyanceId);
    },

    /**
     * 获取管理员数据
     * @returns {*}
     */
    getOrderDataAdmin: function() {
        return axios.get(CONVEYANCE_API + 'getOrderDataAdmin');
    },

    /**
     * 获取推荐数据
     * @param number
     * @returns {*}
     */
    getRecommendData: function(number) {
        return axios.get(CONVEYANCE_API + 'getRecommendData/' + number);
    },

    /**
     * 获取预定数据
     * @returns {*}
     */
    getReserveData: function(resourceId) {
        return axios.get(CONVEYANCE_API + 'getReserveData/' + resourceId);
    },

    /**
     * 租用
     * @param userId
     * @param conveyanceId
     * @param province
     * @param city
     * @param country
     * @param address
     * @param area
     * @param price
     * @param content
     * @returns {*}
     */
    rentItem: function(userId, conveyanceId, province, city, country, address, area, distance, price, content) {
        return axios.post(CONVEYANCE_API + 'rentItem', {
            userId: userId,
            conveyanceId: conveyanceId,
            province: province,
            city: city,
            country: country,
            area: area,
            distance: distance,
            price: price,
            address: address,
            content: content
        });
    },


    /**
     * 接单
     * @param orderId
     * @returns {*}
     */
    acceptItem: function (orderId) {
        return axios.post(CONVEYANCE_API + 'acceptItem', {
            orderId: orderId
        });
    },

    /**
     * 拒单
     * @param orderId
     * @returns {*}
     */
    rejectItem: function (orderId, replyContent) {
        return axios.post(CONVEYANCE_API + 'rejectItem', {
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
        return axios.post(CONVEYANCE_API + 'payItem', {
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
        return axios.post(CONVEYANCE_API + 'finishItem', {
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
        return axios.post(CONVEYANCE_API + 'refundItem', {
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
        return axios.post(CONVEYANCE_API + 'agreeRefund', {
            orderId: orderId
        });
    },


    /**
     * 拒绝退款
     * @param orderId
     * @returns {*}
     */
    disagreeRefund: function (orderId) {
        return axios.post(CONVEYANCE_API + 'disagreeRefund', {
            orderId: orderId
        });
    }

}