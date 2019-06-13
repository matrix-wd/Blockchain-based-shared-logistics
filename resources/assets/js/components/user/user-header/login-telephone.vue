<style lang="less">
    @import "../../../../less/index.less";
    #login-telephone {
        padding: 10px 30px 30px 30px;
        color: black;
        position: fixed;
        z-index: 3;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 320px;
        height: 400px;
        margin: auto;
        background-color: white;
        border-radius: 3px;
        .cancel {
            cursor: pointer;
            font-size: 20px;
            float: right;
        }
        h5 {
            font-weight: 600;
            padding: 20px 0 30px 0;
        }
        .input-box {
            border: 1px solid #cccccc;
            height: 50px;
            input {
                padding-left: 12px;
                font-size: 13px;
                height: 100%;
                border: none;
                width: 100%;
                outline: none;
            }
            .auth_code {
                width: 60%;
            }
            .info_code {
                width: 60%;
            }
            .auth-code-source {
                padding-left: 10px;
                position: relative;
                left: 60%;
                top: -49px;
                background: @primary-color;
                display: inline-block;
                text-align: center;
                line-height: 50px;
                font-size: 16px;
                width: 40%;
                height: 100%;
                letter-spacing: 18px;
                cursor: pointer;
            }
            .info-code {
                width: 68%;
            }
            .get-info-code {
                font-size: 14px;
                outline: none;
                border: none;
                height: 30px;
                padding-left: 10px;
            }
            .active {
                color: @primary-color;
            }
        }
        .no-bottom-box {
            border-bottom: none;
        }
        .login-menu-box {
            font-size: 14px;
            margin: 14px 0;
            .remember-password {
                font-size: 14px;
            }
        }
        .login-btn {
            width: 100%;
            height: 50px;
            background-color: @primary-color;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 3px;
            outline: none;
            cursor: pointer;
        }
        .login-password {
            position: relative;
            color: @primary-color;
            font-size: 14px;
            top: 14px;
            cursor: pointer;
        }
    }
</style>

<template>
    <div id="login-telephone">
        <span class="cancel" @click="cancel">×</span>
        <h5 class="title">验证码登录</h5>
        <div class="input-box no-bottom-box">
            <input type="text" class="telephone" v-model="telephone" placeholder="请输入手机号" />
        </div>
        <div class="input-box no-bottom-box">
            <input type="text" class="auth_code" v-model="userAuthCode" placeholder="请输入验证码"  />
            <span class="auth-code-source box-span" @click="getAuthCode">{{authCode}}</span>
        </div>
        <div class="input-box">
            <input type="text" class="info_code" v-model="userInfoCode" placeholder="请输入短信验证码"  />
            <button class="get-info-code active" :disabled="disabled" @click="getInfoCode">{{getInfoCodeHint}}</button>
        </div>
        <div class="login-menu-box">
            <Checkbox class="remember-password" v-model="rememberPassword">记住密码</Checkbox>
        </div>
        <button class="login-btn" @click="login">登录</button>
        <span class="login-password" @click="loginPassword">帐号密码登录</span>
    </div>
</template>

<script>
    import UserAPI from '../../../api/user.js';
    export default {
        data() {
            return {
                telephone: '',
                userAuthCode: '',
                userInfoCode: '',
                disabled: false,
                getInfoCodeHint: '获取验证码',
                rememberPassword: false,
                timer: null,
                count: 60
            }
        },
        methods: {
            /**
             * 获取验证码
             * */
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
            /**
             * 关闭登录框
             */
            cancel: function () {
                this.$store.dispatch('cancelLoginTelephoneAction');
            },
            /**
             * 帐号密码登录
             */
            loginPassword: function () {
                this.$store.dispatch('loginPasswordAction');
            },
            /**
             * 登录
             * */
            login: function() {
                if(!this.checkInput()) return false;
                let _this = this;
                UserAPI.loginTelephone(this.telephone, this.userAuthCode, this.userInfoCode, this.rememberPassword).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.dispatch('loginSuccessAction', response.data.data);
                        _this.$Message.success('登录成功');
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取短信验证码
             */
            getInfoCode: function () {
                let _this = this;
                UserAPI.getInfoCode(this.telephone).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.disabled = true;
                        _this.countDown();
                    } else {
                        _this.$Message.warning("发送短信失败");
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 倒计时
             * */
            countDown: function() {
                let _this = this;
                this.timer = setInterval(function(){
                    _this.getInfoCodeHint = _this.count--;
                    if(_this.count === 0) {
                        clearInterval(_this.timer);
                        _this.count = 60;
                        _this.getInfoCodeHint = '获取验证码';
                        _this.disabled = false;
                    }
                }, 1000);
            },
            /**
             * 检查输入
             */
            checkInput: function() {
                if(this.telephone.length !== 11) {
                    this.$Message.warning('电话号码长度不正确');
                    return false;
                }
                if(this.userAuthCode.length === 0) {
                    this.$Message.warning('验证码不能为空');
                    return false;
                }
                if(this.userInfoCode.length === 0) {
                    this.$Message.warning('短信验证码不能为空');
                    return false;
                }
                return true;
            }
        },
        computed: {
            /**
             * 验证码
             * @returns {default.computed.authCode|(function())|string|*}
             */
            authCode: function() {
                return this.$store.state.user.authCode;
            }
        }
    }
</script>