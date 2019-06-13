export const attention = {
    state: {
        warehouse: [],
        conveyance: [],
    },
    mutations: {
        /**
         * 设置关注的仓储资源
         * @param state
         * @param data
         */
        setAttentionWarehouse(state, data) {
            state.warehouse = data;
        },
        /**
         * 设置关注的运输资源
         * @param state
         * @param data
         */
        setAttentionConveyance(state, data) {
            state.conveyance = data;
        },
        /**
         * 取消关注仓储资源
         * @param state
         * @param item
         */
        cancelAttentionWarehouse(state, item) {
            state.warehouse.splice(state.warehouse.indexOf(item), 1);
        },
        /**
         * 取消关注运输资源
         * @param state
         * @param item
         */
        cancelAttentionConveyance(state, item) {
            state.conveyance.splice(state.conveyance.indexOf(item), 1);
        }
    },
    actions: {

    }
}