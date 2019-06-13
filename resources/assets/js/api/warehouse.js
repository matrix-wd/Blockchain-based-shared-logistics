const WAREHOUSE_API = 'http://localhost:8081/api/warehouse/';

export default {

    /**
     * 上下架处理
     * @param warehouseId
     * @returns {*}
     */
    updateUsedStatus: function(warehouseId) {
        return axios.post(WAREHOUSE_API + 'updateUsedStatus', {
            warehouseId: warehouseId
        });
    },

    /**
     * 创建仓储资源
     * @param telephone
     * @param password
     * @returns {*}
     */
    createWarehouse: function (warehouse, warehouseImage) {
        return axios.post(WAREHOUSE_API + 'createWarehouse', {
            warehouse: warehouse,
            warehouseImage: warehouseImage
        });
    },


    /**
     * 修改仓储资源
     * @param warehouse
     * @param warehouseImage
     * @returns {*}
     */
    updateWarehouse: function (warehouse, warehouseImage) {
        return axios.post(WAREHOUSE_API + 'updateWarehouse', {
            warehouse: warehouse,
            warehouseImage: warehouseImage
        });
    },

    /**
     * 删除文件
     * @param fileName
     * @returns {*}
     */
    deleteFile: function (fileName) {
        return axios.post(WAREHOUSE_API + 'deleteFile', {
            fileName: fileName
        });
    },

    /**
     * 获取数据
     * @returns {*}
     */
    getData: function (condition) {
        return axios.post(WAREHOUSE_API + 'getData', {
            condition: condition
        });
    },

    /**
     * 获取用户发布的仓储资源
     * @param userId
     * @returns {*}
     */
    getDataByUserId: function(userId) {
        return axios.get(WAREHOUSE_API + 'getDataByUserId/' + userId);
    },

    /**
     * 获取选择数据
     * @returns {*}
     */
    getSelectData: function () {
        return axios.get(WAREHOUSE_API + 'getSelectData');
    },

    /**
     * 根据面积获取数据
     * @param condition
     * @returns {*}
     */
    getDataOrderByArea: function (condition) {
        return axios.post(WAREHOUSE_API + 'getData', {
            condition: condition
        });
    },
    /**
     * 获取订单信息
     * @param warehouseId
     * @returns {*}
     */
    getWarehouseOrderInfo: function (warehouseId) {
        return axios.get(WAREHOUSE_API + 'getWarehouseOrderInfo/' + warehouseId);
    },
    /**
     * 获取基本信息
     * @param warehouseId
     * @returns {*}
     */
    getInfo: function (warehouseId) {
        return axios.get(WAREHOUSE_API + warehouseId);
    },

    /**
     * 获取仓储数据 管理员
     * @returns {*}
     */
    getWarehouseDataAdmin: function () {
        return axios.get(WAREHOUSE_API + 'getWarehouseDataAdmin');
    },

    /**
     * 获取仓储订单数据 管理员
     * @returns {*}
     */
    getWarehouseOrderDataAdmin: function () {
        return axios.get(WAREHOUSE_API + 'getWarehouseOrderDataAdmin');
    },
    /**
     * 审核通过
     * @param warehouseId
     * @returns {*}
     */
    passWarehouse: function (warehouseId) {
        return axios.post(WAREHOUSE_API + 'passWarehouse', {
            warehouseId: warehouseId
        });
    },
    /**
     * 审核不通过
     * @param warehouseId
     * @returns {*}
     */
    rejectWarehouse: function (warehouseId) {
        return axios.post(WAREHOUSE_API + 'rejectWarehouse', {
            warehouseId: warehouseId
        });
    }
}