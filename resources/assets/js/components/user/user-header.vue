<style lang="less">
    @import '../../../less/index.less';
    #user-header-box {
        background-color: #4e4e4e;
        color: white;
        padding: 10px 0;
        .menu-ul,
        .login-ul {
            li {
                font-size: 14px;
                color: gray;
                display: inline-block;
                list-style: none;
                cursor: pointer;
            }
            li:hover {
                color: white;
            }
        }
        .menu-ul {
            li {
                margin-right: 30px;
            }
        }
        .login-ul {
            text-align: right;
            li {
                margin-left: 30px;
            }
            .login-register {
                span {
                    padding: 0 5px;
                }
                span:hover {
                    color: white;
                }
            }
            .login-register:hover {
                color: gray;
            }
            .phone {
                cursor: text;
            }
            .phone:hover {
                color: gray;
                cursor: text;
            }
            .phone::selection {
                background: @primary-color;
                color: white;
            }
        }
    }

</style>

<template>
    <div id="user-header-box">
        <userLogin></userLogin>
        <Row>
            <Col span="12" offset="2">
                <ul class="menu-ul">
                    <li @click="goHome">首页</li>
                    <li @click="goConveyance">运输资源</li>
                    <li @click="goWarehouse">仓储资源</li>
                    <li @click="goGuide">指南</li>
                    <li @click="goTool">工具</li>
                    <li @click="goResource">发布资源</li>
                </ul>
            </Col>
            <Col span="8">
                <ul class="login-ul">
                    <li class="login-register" v-show="!userStatus">
                        <span @click="register">注册</span>
                        <span @click="login">登录</span>
                    </li>
                    <li class="login-register" v-show="userStatus">
                        <span @click="goUserInfo">{{telephone}}</span>
                        <span @click="logout">退出</span>
                    </li>
                    <li class="phone">
                        热点电话：0671-3816410
                    </li>
                </ul>
            </Col>
        </Row>
        <myMask></myMask>
    </div>
</template>

<script>
    import UserAPI from '../../api/user.js';
    import myMask from './my-mask.vue';
    import Tools_API from '../../api/tools.js';
    import userLogin from './user-header/login.vue';
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
             * 注册
             */
            register: function() {
                this.$store.dispatch("registerBtnAction");
            },
            /**
             * 登录
             */
            login: function () {
                this.$store.dispatch('loginBtnAction');
            },
            /**
             * 首页
             */
            goHome: function () {
                this.$router.push('/');
            },
            /**
             *  工具页面
             */
            goTool: function() {
                this.$router.push('/tools');
            },
            /**
             * 仓储页面
             */
            goWarehouse: function () {
                this.$router.push('/warehouse');
            },
            /**
             * 运输资源
             */
            goConveyance: function () {
                this.$router.push('/conveyance');
            },
            /**
             * 查看相关指南
             */
            goGuide: function() {
                this.$router.push('/guide');
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
            /**
             * 用户信息页面
             * */
            goUserInfo: function() {
                this.$router.push('/userInfo');
            },

        },
        computed: {
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
            userLogin,
            myMask
        }
    }
</script>