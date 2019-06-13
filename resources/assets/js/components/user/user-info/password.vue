<style lang="less">
    @import '../../../../less/index.less';
    @import '../../../../less/user-info.less';
    #user-info-password {
        .form-box {
            margin-top:100px;
        }
    }
</style>

<template>
    <div id="user-info-password" class="user-info-content-box">
        <Row>
            <Col span="24">
                <h4 class="title">修改密码</h4>
            </Col>
            <div class="form-box">
                <Form :model="password" :rules="ruleValidate"  :label-width="90">
                    <FormItem label="旧密码" prop="oldPassword">
                        <Row>
                            <Col span="12">
                                <Input type="password" v-model="password.old" placeholder="请输入您之前的密码"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem label="新密码" prop="newPassword">
                        <Row>
                            <Col span="12">
                                <Input type="password" v-model="password.new" placeholder="请输入不少于6为的新密码"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem label="重复" prop="passwordAgain">
                        <Row>
                            <Col span="12">
                                <Input type="password" v-model="password.again" placeholder="请再次输入您的新密码"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" size="large" @click="submit">提交</Button>
                    </FormItem>
                </Form>
            </div>
        </Row>
    </div>
</template>

<script>
    import UserAPI from '../../../api/user.js';
    export default {
        data() {
            return {
                showPrice: false,
                password: {
                    old: '',
                    new: '',
                    again: '',
                },
                ruleValidate: {
                    old: [
                        { required: true, message: '密码不能为空', trigger: 'blur' }
                    ],
                    new: [
                        { required: true, message: '密码不能为空', trigger: 'blur' }
                    ],
                    again: [
                        { required: true, message: '密码不能为空', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            submit: function () {
                if(!this.checkInput()) return false;
                let _this = this;
                let userId = this.$store.state.user.userInfo.userId;
                UserAPI.updatePasswordAfterLogin(userId, this.password).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('修改成功');
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            checkInput: function() {
                if(this.password.old.length < 6 || this.password.new.length < 6 || this.password.again.length < 6) {
                    this.$Message.warning('密码长度不正确')
                    return false;
                }
                if(this.password.new !== this.password.again) {
                    this.$Message.warning('前后密码不一致')
                    return false;
                }
                return true;
            }
        }
    }
</script>