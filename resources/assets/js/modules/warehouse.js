export const warehouse = {
    state: {
        warehouse: {},
        createWarehouse: {},
        selectWarehouseData: {},
        condition: {
            price: [],
            length: [],
            width: [],
            height: [],
            category: ['公司', '个人'],
            environment: [],
            orderData: 'warehouseId',
            method: 'desc',
            city: '',
            searchData: '',
        }
    },
    mutations: {
        /**
         * 设置仓储资源
         * @param state
         * @param data
         */
        setWarehouseInfo(state, data) {
            state.warehouse = data;
        },
        /**
         * 创建成功
         * @param state
         * @param warehouse
         */
        createWarehouseSuccess(state, warehouse) {
            state.createWarehouse = warehouse;
        },
        /**
         * 设置仓储资源田间
         * @param state
         * @param condition
         */
        setWarehouseCondition(state, condition) {
            state.condition.price = condition.price;
            state.condition.length = condition.length;
            state.condition.width = condition.width;
            state.condition.height = condition.height;
        },
        /**
         * 设置仓储资源的选择值
         * @param state
         * @param data
         */
        setSelectWarehouseData(state, data) {
            state.selectWarehouseData = data;
        },
        /**
         * 改变仓储资源的过滤长度
         * @param state
         * @param length
         */
        changeWarehouseConditionLength(state, length) {
            state.condition.length = length;
        },
        /**
         * 改变仓储资源的过滤宽度
         * @param state
         * @param width
         */
        changeWarehouseConditionWidth(state, width) {
            state.condition.width = width;
        },
        /**
         * 改变仓储资源的过滤高度
         * @param state
         * @param height
         */
        changeWarehouseConditionHeight(state, height) {
            state.condition.height = height;
        },
        /**
         * 改变仓储资源的过滤价格
         * @param state
         * @param price
         */
        changeWarehouseConditionPrice(state, price) {
            state.condition.price = price;
        },
        /**
         * 改变仓储资源的所属类别
         * @param state
         * @param category
         */
        changeWarehouseConditionCategory(state, category) {
            state.condition.category = category;
        },
        /**
         * 改变仓储资源的类型
         * @param state
         * @param environment
         */
        changeWarehouseConditionEnvironment(state, environment) {
            state.condition.environment = environment;
        }
    },
    actions: {},
};