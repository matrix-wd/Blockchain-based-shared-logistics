<style lang="less">

</style>

<template>
    <div id="user-login">
        <loginTelephone v-show="loginTelephoneStatus"></loginTelephone>
        <loginPassword v-show="loginPasswordStatus"></loginPassword>
        <register v-show="registerStatus"></register>
        <forgetPassword v-show="forgetPassword"></forgetPassword>
    </div>
</template>

<script>
    import UserAPI from '../../../api/user.js';
    import loginTelephone from './login-telephone.vue';
    import loginPassword from './login-password.vue';
    import register from './register.vue';
    import forgetPassword from './forget-password.vue';
    export default {
        data() {
            return {

            }
        },
        mounted: function() {
            this.loginStatus();
        },
        methods: {
            /**
             * 当前登录状态
             * */
            loginStatus: function () {
                let _this = this;
                UserAPI.loginStatus().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.dispatch('loginSuccessAction', response.data.data);
                    } else {
                        _this.getAuthCode();
                    }
                }).catch( function(){
                    _this.$Message.warning('获取登录状态请求出现异常');
                });
            },
            /**
             *  获取验证码
             */
            getAuthCode: function() {
                let _this = this;
                UserAPI.getAuthCode().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.commit('setAuthCode', response.data.data);
                    } else {
                        _this.$Message.warning("获取验证码失败");
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
        },
        computed: {
            /**
             * 密码登录模块显示状态
             * @returns {default.computed.loginTelephoneStatus|(function())|boolean|__webpack_exports__.default.computed.loginTelephoneStatus|loginTelephoneStatus}
             */
            loginTelephoneStatus: function() {
                return this.$store.state.user.loginTelephoneStatus;
            },
            /**
             * 验证码登录模块显示状态
             * @returns {default.computed.loginPasswordStatus|(function())|boolean|__webpack_exports__.default.computed.loginPasswordStatus|loginPasswordStatus}
             */
            loginPasswordStatus: function() {
                return this.$store.state.user.loginPasswordStatus;
            },
            /**
             * 注册模块显示状态
             * @returns {default.computed.registerStatus|(function())|boolean|__webpack_exports__.default.computed.registerStatus|registerStatus}
             */
            registerStatus: function() {
                return this.$store.state.user.registerStatus;
            },
            /**
             * 忘记密码模块显示状态
             * @returns {boolean}
             */
            forgetPassword: function () {
                return this.$store.state.user.forgetPasswordStatus;
            }
        },
        components: {
            loginTelephone,
            loginPassword,
            register,
            forgetPassword
        }
    }
</script>