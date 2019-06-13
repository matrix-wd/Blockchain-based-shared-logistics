
export const user = {
    state: {
        maskStatus: false,
        loginTelephoneStatus: false,
        loginPasswordStatus: false,
        registerStatus: false,
        forgetPasswordStatus: false,
        userModal: false,
        userInfo: {},
        userStatus: false, // true表示登录状态
        authCode: '',
    },
    mutations: {
        /**
         * 展示用户弹窗
         * @param state
         */
        showUserModal(state) {
           state.userModal = true;
           state.maskStatus = true;
        },
        /**
         * 隐藏用户弹窗
         * @param state
         */
        hiddenUserModal(state) {
           state.userModal = false;
            state.maskStatus = false;
        },
        /**
         * 展示遮罩
         * @param state
         */
        showMask(state) {
            state.maskStatus = true;
        },
        /**
         * 隐藏遮罩
         * @param state
         */
        hiddenMask(state) {
            state.maskStatus = false;
        },
        /**
         * 展示验证码登录模块
         * @param state
         */
        showLoginTelephone(state) {
            state.loginTelephoneStatus = true;
        },
        /**
         * 隐藏验证码登录模块
         * @param state
         */
        hiddenLoginTelephone(state) {
            state.loginTelephoneStatus = false;
        },
        /**
         * 展示密码登录模块
         * @param state
         */
        showLoginPassword(state) {
            state.loginPasswordStatus = true;
        },
        /**
         * 隐藏密码登录模块
         * @param state
         */
        hiddenLoginPassword(state) {
            state.loginPasswordStatus = false;
        },
        /**
         * 展示注册模块
         * @param state
         */
        showRegister(state) {
            state.registerStatus = true;
        },
        /**
         * 隐藏模块模块
         * @param state
         */
        hiddenRegister(state) {
            state.registerStatus = false;
        },
        /**
         * 展示忘记密码模块
         * @param state
         */
        showForgetPassword(state) {
            state.forgetPasswordStatus = true;
        },
        /**
         * 隐藏忘记密码模块
         * @param state
         */
        hiddenForgetPassword(state) {
            state.forgetPasswordStatus = false;
        },
        /**
         * 登录成功
         * @param state
         */
        loginSuccess(state, userInfo) {
            state.userStatus = true;
            state.userInfo = userInfo;
        },
        /**
         * 修改用户信息
         * @param state
         * @param user
         */
        updateInfoSuccess(state, user) {
            state.userInfo = user;
        },
        /**
         * 退出
         * @param state
         */
        logout(state) {
            state.userStatus = false;
            state.userInfo = [];
        },
        /**
         * 设置验证码
         * @param authCode
         */
        setAuthCode(state, authCode) {
            state.authCode = authCode;
        }
    },
    actions: {
        /**
         * 导航模块中的登录按钮
         * @param context
         */
        loginBtnAction(context) {
            context.commit('showMask');
            context.commit('showLoginPassword');
        },
        /**
         * 遮罩
         * @param context
         */
        maskAction(context) {
            context.commit('hiddenUserModal');
            context.commit('hiddenMask');
            context.commit('hiddenLoginPassword');
            context.commit('hiddenRegister');
            context.commit('hiddenLoginTelephone');
            context.commit('hiddenForgetPassword');
        },
        /**
         * 帐号登录模块的取消按钮
         * @param context
         */
        cancelLoginPasswordAction(context) {
            context.commit('hiddenMask');
            context.commit('hiddenLoginPassword');
        },
        /**
         * 验证码登录模块的取消按钮
         * @param context
         */
        cancelLoginTelephoneAction(context) {
            context.commit('hiddenMask');
            context.commit('hiddenLoginTelephone');
        },
        /**
         * 导航模块中的注册按钮
         * @param context
         */
        registerBtnAction(context) {
            context.commit('showMask');
            context.commit('showRegister');
        },
        /**
         * 注册模块的取消按钮
         * @param context
         */
        cancelRegisterAction(context) {
            context.commit('hiddenMask');
            context.commit('hiddenRegister');
        },
        /**
         * 注册模块中的去登录按钮
         * @param context
         */
        goLoginAction(context) {
            context.commit('hiddenRegister');
            context.commit('showLoginPassword');
        },
        /**
         * 验证码登录模块的密码登录
         * @param context
         */
        loginPasswordAction(context) {
            context.commit('hiddenLoginTelephone');
            context.commit('showLoginPassword');
        },
        /**
         * 密码登录模块的验证码登录
         * @param context
         */
        loginTelephoneAction(context) {
            context.commit('hiddenLoginPassword');
            context.commit('showLoginTelephone');
        },
        /**
         * 密码登录模块的忘记密码
         * @param context
         */
        forgetPasswordAction(context) {
            context.commit('hiddenLoginPassword');
            context.commit('showForgetPassword');
        },
        /**
         * 忘记密码模块的取消按钮
         * @param context
         */
        cancelForgetPasswordAction(context) {
            context.commit('hiddenMask');
            context.commit('hiddenForgetPassword');
        },
        /**
         * 登录成功
         * @param context
         * @param state
         * @param userinfo
         */
        loginSuccessAction(context, userInfo) {
            this.dispatch('maskAction');
            this.commit('loginSuccess', userInfo);
        }
    }
}