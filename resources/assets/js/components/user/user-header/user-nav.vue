<style lang="less">
    #user-nav {
        float: right;
        margin-right: 100px;
        .login-register-box {
            font-size: 14px;
            float: right;
            margin-right: 16px;
            padding-bottom: 12px;
            .menu-span {
                position: relative;
                cursor: pointer;
                top: 2px;
                left: 6px;
            }
        }
        .user-nav-box {
            clear: both;
            .user-nav-ul {
                list-style: none;
                font-size: 16px;
                li {
                    display: inline-block;
                    margin: 0 8px;
                    cursor: pointer;
                }
            }
        }
    }
</style>

<template>
    <div id="user-nav">
        <div class="login-register-box" v-show="!userStatus">
            <Icon type="ios-contact-outline" size="18" />
            <span class="menu-span" @click.stop="login">登录</span>
            <span class="menu-span" @click.stop="register">立即注册</span>
        </div>
        <div class="login-register-box" v-show="userStatus">
            <span class="menu-span" @click="goUserInfo">{{telephone}}</span>
            <span class="menu-span" @click="logout">退出</span>
        </div>
        <userLogin></userLogin>
        <div class="user-nav-box">
            <ul class="user-nav-ul">
                <li @click="goConveyance">运输资源</li>
                <li @click="goWarehouse">仓储资源</li>
                <li @click="goGuide">指南</li>
                <li @click="goTool">工具</li>
                <li @click="goResource">
                    <Icon type="md-egg" size="10" color="white" />
                    发布资源
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import UserAPI from '../../../api/user.js';
    import Tools_API from '../../../api/tools.js';
    import userLogin from './login.vue';
    export default {
        data() {
            return {

            }
        },
        mounted: function() {
            let _this = this;
            setTimeout(function () {
                if(_this.$store.state.home.priceUsd === null) {
                    _this.getPriceUsd();
                }
            }, 50);
        },
        methods: {
            /**
             * 获取价格转换率
             */
            getPriceUsd: function() {
                let _this = this;
                Tools_API.RmbToEth().then( function(response){
                    _this.$store.commit('setPriceUsd', response.data.data);
                }).catch( function(){
                    this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 登录按钮
             */
            login: function() {
                this.$store.dispatch('loginBtnAction');
            },
            /**
             * 注册按钮
             */
            register: function () {
                this.$store.dispatch("registerBtnAction");
            },
            /**
             * 仓储资源
             */
            goWarehouse: function () {
                this.$router.push('/warehouse');
            },
            /**
             * 指南页面
             */
            goGuide: function() {
                this.$router.push('/guide');
            },
            /**
             * 工具页面
             */
            goTool: function() {
                this.$router.push('/tools');
            },
            /**
             * 运输资源
             */
            goConveyance: function () {
                this.$router.push('/conveyance');
            },
            /**
             * 用户信息页面
             * */
            goUserInfo: function() {
                this.$router.push('/userInfo');
            },
            /**
             * 发布资源
             */
            goResource: function() {
                this.$router.push('/createResourceHint');
            },
            /**
             * 退出
             * */
            logout: function () {
                let index = this.$store.state.home.LogoutReturnIndexRoute.indexOf(this.$router.currentRoute.name);
                let _this = this;
                UserAPI.logout().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.commit('logout');
                        _this.$Message.success('退出成功');
                        if(index >=0) {
                            _this.$router.back();
                        }
                    }
                }).catch( function(){
                    _this.$Message.warning('退出请求出现异常');
                });
            },
        },
        computed: {
            /**
             * 用户当前状态
             * @returns {default.computed.userStatus|(function())|boolean}
             */
            userStatus: function() {
                return this.$store.state.user.userStatus;
            },
            telephone: function() {
                let telephone = this.$store.state.user.userInfo.telephone;
                if(telephone) {
                    return telephone.slice(0, 3) + '***' + telephone.slice(7, 11);
                }
                return telephone;
            }
        },
        components: {
            userLogin
        }
    }
</script>