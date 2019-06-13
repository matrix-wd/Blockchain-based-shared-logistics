<style lang="less">
    @import "../../../../less/index.less";
    #forget-password {
        padding: 10px 30px 30px 30px;
        color: black;
        position: fixed;
        z-index: 3;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 360px;
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
            padding: 26px 0 30px 0;
        }
        .input-box {
            height: 50px;
            border: 1px solid #ccc;
            border-bottom: none;
            input {
                outline: none;
                padding-left: 14px;
                font-size: 13px;
                height: 100%;
                border: none;
                width: 100%;
            }
            .auth-code {
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
        .last-child {
            border-bottom: 1px solid #cccccc;

        }
        .update-password {
            margin-top: 28px;
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
    }
</style>

<template>
    <div id="forget-password">
        <span class="cancel" @click="cancel">×</span>
        <h5 class="title">找回密码</h5>
        <div class="input-box">
            <input type="text" class="telephone" v-model="telephone" placeholder="请输入手机号" />
        </div>
        <div class="input-box">
            <input type="text" class="auth-code" v-model="userAuthCode" placeholder="请输入验证码"  />
            <span class="auth-code-source" @click="getAuthCode">{{authCode}}</span>
        </div>
        <div class="input-box">
            <input type="text" class="info-code" v-model="userInfoCode" placeholder="请输入短信验证码"  />
            <button class="get-info-code active" :disabled="disabled" @click="getInfoCode">{{getInfoCodeHint}}</button>
        </div>
        <div class="input-box last-child">
            <input type="password" class="password" v-model="password" placeholder="请输入密码(最少6位)"  />
        </div>
        <button class="update-password" @click="updatePassword">修改密码</button>
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
                authCode: '',
                password: '',
                disabled: false,
                getInfoCodeHint: '获取验证码',
                timer: null,
                count: 60
            }
        },
        mounted: function() {
            this.getAuthCode();
        },
        methods: {
            /**
             * 获取验证码
             * */
            getAuthCode: function() {
                let _this = this;
                UserAPI.getAuthCode().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.authCode = response.data.data;
                    } else {
                        _this.$Message.warning("获取验证码失败");
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 取消按钮
             */
            cancel: function () {
                this.$store.dispatch('cancelForgetPasswordAction');
            },
            /**
             * 获取短信验证码
             */
            getInfoCode: function () {
                let _this = this;
                UserAPI.getInfoCode(this.telephone).then( function(response){
                    console.log(response.data.data);
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
             * 修改密码
             */
            updatePassword: function () {
                if(!this.checkInput()) return false;
                let _this = this;
                UserAPI.updatePassword(this.telephone, this.userAuthCode, this.userInfoCode, this.password).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.dispatch('maskAction');
                        _this.$Message.warning('修改成功，请重新登录');
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
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
                if(this.password.length <= 6) {
                    this.$Message.warning('密码不能少于6位');
                    return false;
                }
                return true;
            }
        }
    }
</script>