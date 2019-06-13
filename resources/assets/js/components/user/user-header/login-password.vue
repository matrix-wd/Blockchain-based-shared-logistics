<style lang="less">
    @import "../../../../less/index.less";
    #login-password {
        padding: 10px 30px 30px 30px;
        color: black;
        position: fixed;
        z-index: 3;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 320px;
        height: 360px;
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
                outline: none;
                padding-left: 12px;
                font-size: 13px;
                height: 100%;
                border: none;
            }
            input:hover {
                border: none;
            }
        }
        .first-box {
            border-bottom: none;
        }
        .login-menu-box {
            font-size: 14px;
            margin: 14px 0;
            .forget-password {
                cursor: pointer;
                float: right;
            }
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
        .login-telephone {
            position: relative;
            color: @primary-color;
            font-size: 14px;
            top: 14px;
            cursor: pointer;
        }
    }
</style>

<template>
    <div id="login-password">
        <span class="cancel" @click="cancel">×</span>
        <h5 class="title">帐号密码登录</h5>
        <div class="input-box first-box">
            <input type="text" class="telephone" v-model="telephone" placeholder="请输入手机号" />
        </div>
        <div class="input-box">
            <input type="password" class="password" v-model="password" placeholder="请输入登录密码"  />
        </div>
        <div class="login-menu-box">
            <Checkbox class="remember-password" v-model="rememberPassword">记住密码</Checkbox>
            <span class="forget-password" @click="forgetPassword">忘记密码</span>
        </div>
        <button class="login-btn" @click="loginBtn">登录</button>
        <span class="login-telephone" @click="loginTelephone">手机快捷登录</span>
    </div>
</template>

<script>
    import UserAPI from '../../../api/user.js';
    export default {
        data() {
            return {
                telephone: '',
                password: '',
                rememberPassword: false
            }
        },
        methods: {
            /**
             * 关闭登录框
             */
            cancel: function () {
                this.$store.dispatch('cancelLoginPasswordAction');
            },
            /**
             * 帐号密码登录
             */
            loginTelephone: function () {
                this.$store.dispatch('loginTelephoneAction');
            },
            /**
             * 忘记密码
             */
            forgetPassword: function () {
                this.$store.dispatch('forgetPasswordAction');
            },
            /**
             * 登录按钮
             */
            loginBtn: function () {
                if(!this.checkInput()) return false;
                let _this = this;
                UserAPI.loginPassword(this.telephone, this.password, this.rememberPassword).then( function(response){
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
             * 检查用户的输入是否合法
             */
            checkInput: function() {
                if(this.telephone.length !== 11) {
                    this.$Message.warning('电话号码长度不正确');
                    return false;
                }
                if(this.password.length === 0) {
                    this.$Message.warning('密码不能为空');
                    return false;
                }
                return true;
            }
        }
    }
</script>