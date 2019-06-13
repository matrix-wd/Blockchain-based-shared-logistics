<style lang="less">
    @import "../../../less/index.less";
    #Index {
        height: 100%;
        .img-box {
            position: absolute;
            height: 100%;
            width: 100%;
            z-index: -1;
            img {
                height: 100%;
                width: 100%;
            }
        }
        .login-password-box {
            padding: 10px 30px 30px 30px;
            color: black;
            position: fixed;
            z-index: 3;
            left: 60%;
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
                font-size: 22px;
                font-weight: 600;
                padding: 20px 0 30px 0;
            }
            .input-box {
                border: 1px solid #cccccc;
                height: 50px;
                margin-top: 16px;
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
            /*.first-box {*/
                /*border-bottom: none;*/
            /*}*/
            .login-btn {
                margin-top: 40px;
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
    }
</style>
<template>
    <div id="Index">
        <div class="img-box">
            <img src="../../../img/admin.png"  alt="logo" />
        </div>
        <div class="login-password-box">
            <h5 class="title">登录</h5>
            <div class="input-box first-box">
                <input type="text" class="telephone" v-model="telephone" placeholder="请输入手机号" />
            </div>
            <div class="input-box">
                <input type="password" class="password" v-model="password" placeholder="请输入登录密码"  />
            </div>
            <button class="login-btn" @click="loginBtn">登录</button>
        </div>
    </div>
</template>

<script>

    import AdminAPI from '../../api/admin.js';
    export default {
        data() {
            return {
                telephone: '15579766403',
                password: '123456',
            }
        },
        methods: {
            /**
             * 登录按钮
             */
            loginBtn: function () {
                let _this = this;
                AdminAPI.login(this.telephone, this.password).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.commit('adminLoginSuccess', response.data.data);
                        _this.$router.push('/dashboard');
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            }
        }
    }
</script>