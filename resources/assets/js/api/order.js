const ODER_API = 'http://localhost:8081/api/orders/';

export default {
    /**
     * 价格估计
     * @param conveyanceInfo
     * @returns {*}
     */
    calculatePrice: function (conveyanceInfo) {
        return axios.post(ODER_API + 'calculatePrice', {
            conveyanceInfo: conveyanceInfo
        });
    },

    /**
     * 获取仓储订单资源
     * @returns {*}
     */
    getWarehouseOrderData: function () {
        return axios.get(ODER_API + 'getWarehouseOrderData');
    },

    /**
     * 获取运输订单资源
     * @returns {*}
     */
    getConveyanceOrderData: function () {
        return axios.get(ODER_API + 'getConveyanceOrderData');
    },

    /**
     * 获取推荐的仓储数据
     * @returns {*}
     */
    getRecommendWarehouseData: function (number) {
        if (!number) {
            return axios.get(ODER_API + 'getRecommendWarehouseData');
        }
        return axios.get(ODER_API + 'getRecommendWarehouseData/' + number);
    }
    ,

    /**
     * 获取推荐的运输数据
     * @returns {*}
     */
    getRecommendConveyanceData: function (number) {
        if(!number) {
            return axios.get(ODER_API + 'getRecommendConveyanceData');
        }
        return axios.get(ODER_API + 'getRecommendConveyanceData/' + number);
    },

    /**
     * 租用
     * @param userId
     * @param id
     * @param type
     * @param startDate
     * @param endDate
     * @param area
     * @param price
     * @returns {*}
     */
    rentItem: function (userId, id, type, startDate, endDate, area, price) {
        return axios.post(ODER_API + 'rentItem', {
            userId: userId,
            id: id,
            type: type,
            startDate: startDate,
            endDate: endDate,
            area: area,
            price: price
        });
    }
}