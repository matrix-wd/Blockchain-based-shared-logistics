export const admin = {
    state: {
        admin: [],
        status: false,  //登录状态,
        currentPage: 1,
        pageSize: 12,
    },
    mutations: {
        /**
         * 登录成功
         * @param state
         * @param data
         */
        adminLoginSuccess(state, data) {
            state.status = true;
            state.admin = data;
        },
        /**
         * 设置当前页面
         * @param state
         * @param page
         */
        setCurrentPage(state, page) {
            state.currentPage = page;
        }
    },
    actions: {

    }
}