export const home = {
    state: {
        currentCity: '北京',
        updateData: [],
        itemStatus: 'create',
        priceUsd: null,
        searchInfo: '',
        LogoutReturnIndexRoute: ["userInfo", "createWarehouse", "createConveyance"]
    },
    mutations: {
        /**
         * 设置转换率
         * @param state
         * @param priceUsd
         */
        setPriceUsd(state, priceUsd) {
            state.priceUsd = priceUsd;
        },
        /**
         * 设置当前城市
         * @param state
         * @param city
         */
        setCurrentCity(state, city) {
            state.currentCity = city;
        },
        /**
         * 设置修改项目
         * @param state
         * @param data
         */
        setUpdateItem(state, data) {
            state.updateData = data;
            state.itemStatus = 'update';
        },
        /**
         * 设置项目状态
         * @param state
         * @param status
         */
        setItemStatus(state, status) {
            state.itemStatus = status;
        },
        /**
         * 设置搜索信息
         * @param state
         * @param searchInfo
         */
        setSearchInfo(state, searchInfo) {
            state.searchInfo = searchInfo;
        },
        /**
         * 清空数据
         * @param state
         */
        clearSearchInfo(state) {
            state.searchInfo = '';
        }
    },
    actions: {

    }
}