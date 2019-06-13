export const resource = {
    state: {
        type: '',
        item: {},
    },
    mutations: {
        /**
         * 设置类型
         * @param state
         * @param type
         */
        setType(state, type) {
            state.type = type;
        },
        /**
         * 设置item
         * @param state
         * @param item
         */
        setItem(state, item) {
            state.item = item;
        }
    },
    actions: {

    }
}