export const conveyance = {
    state: {
        conveyance: {},
        selectConveyanceData: {},
        currentPage: 1,
        condition: {
            price: [],
            length: [],
            width: [],
            height: [],
            maxWeight: [],
            category: ['公司', '个人'],
            type: ['大货车', '普通货车', '小货车', '面包车', '其他'],
            orderData: 'conveyanceId',
            method: 'desc',
            city: '',
            searchData: '',
        }
    },
    mutations: {
        /**
         * 设置运输信息
         * @param state
         * @param conveyance
         */
        setConveyanceInfo(state, conveyance) {
            state.conveyance = conveyance;
        },
        /**
         * 创建成功
         * @param state
         * @param conveyance
         */
        createConveyance(state, conveyance) {
            state.conveyance = conveyance;
        },
        /**
         * 设置conveyance的选择数据
         */
        setSelectConveyanceData(state, data) {
            state.selectConveyanceData = data;
        },
        /**
         * 设置运输资源过滤条件
         * @param state
         * @param condition
         */
        setConveyanceCondition(state, condition) {
            state.condition.price = condition.price;
            state.condition.length = condition.length;
            state.condition.width = condition.width;
            state.condition.height = condition.height;
            state.condition.maxWeight = condition.maxWeight;
        },
        /**
         * 改变运输资源的过滤长度
         * @param state
         * @param length
         */
        changeConveyanceConditionLength(state, length) {
            state.condition.length = length;
        },
        /**
         * 改变运输资源的过滤宽度
         * @param state
         * @param width
         */
        changeConveyanceConditionWidth(state, width) {
            state.condition.width = width;
        },
        /**
         * 改变运输资源的过滤高度
         * @param state
         * @param height
         */
        changeConveyanceConditionHeight(state, height) {
            state.condition.height = height;
        },
        /**
         * 改变运输资源的过滤载重
         * @param state
         * @param weight
         */
        changeConveyanceConditionWeight(state, weight) {
            state.condition.maxWeight = weight;
        },
        /**
         * 改变运输资源的过滤价格
         * @param state
         * @param price
         */
        changeConveyanceConditionPrice(state, price) {
            state.condition.price = price;
        },
        /**
         * 改变运输资源的所属类别
         * @param state
         * @param price
         */
        changeConveyanceConditionCategory(state, category) {
            state.condition.category = category;
        },
        /**
         * 改变运输资源的类型
         * @param state
         * @param type
         */
        changeConveyanceConditionType(state, type) {
            state.condition.type = type;
        }
    },
    actions: {},
};