<style lang="less">
    @import '../../../../less/index.less';
    @import '../../../../less/user-info.less';
    #user-info-info {
        .form-box {
            margin-top: 50px;
        }
    }
</style>

<template>
    <div id="user-info-info" class="user-info-content-box">
        <Row>
            <Col span="24">
                <h4 class="title">完善个人信息</h4>
                <div class="form-box">
                    <Form :model="user" ref="user" :rules="ruleValidate" :label-width="90">
                        <FormItem label="姓名" prop="username">
                            <Row>
                                <Col span="12">
                                    <Input v-model="user.username" placeholder="请输入真实姓名"></Input>
                                </Col>
                            </Row>
                        </FormItem>
                        <FormItem label="性别">
                            <RadioGroup v-model="user.gender">
                                <Radio label="男">男</Radio>
                                <Radio label="女">女</Radio>
                            </RadioGroup>
                        </FormItem>
                        <FormItem label="身份证号码" prop="idCard">
                            <Row>
                                <Col span="12">
                                    <Input v-model="user.idCard" placeholder="请输入身份证号码"></Input>
                                </Col>
                            </Row>
                        </FormItem>
                        <FormItem label="以太坊地址" prop="blockChainAddress">
                            <Row>
                                <Col span="12">
                                    <Input v-model="user.blockChainAddress" placeholder="请输入以太坊地址"></Input>
                                </Col>
                            </Row>
                        </FormItem>
                        <Row>
                            <Col span="6">
                                <FormItem prop="province" label="省份">
                                    <Select v-model="user.province" placeholder="请选择省份" filterable @on-change="getCity">
                                        <Option v-for="item in province" :value="item.code">{{item.name}}</Option>
                                    </Select>
                                </FormItem>
                            </Col>
                            <Col span="6" offset="1">
                                <FormItem prop="city" label="城市">
                                    <Select v-model="user.city" placeholder="请选择城市" filterable @on-change="getCountry">
                                        <Option v-for="item in city" :value="item.code">{{item.name}}</Option>
                                    </Select>
                                </FormItem>
                            </Col>
                            <Col span="6" offset="1">
                                <FormItem prop="country" label="地区">
                                    <Select v-model="user.country" placeholder="请选择地区" filterable>
                                        <Option v-for="item in country" :value="item.name">{{item.name}}</Option>
                                    </Select>
                                </FormItem>
                            </Col>
                        </Row>
                        <FormItem label="详细地址">
                            <Row>
                                <Col span="20">
                                    <Input v-model="user.address" placeholder="请输入您的详细地址"></Input>
                                </Col>
                            </Row>
                        </FormItem>
                        <FormItem>
                            <Button type="primary" size="large" @click="submit('user')">提交</Button>
                        </FormItem>
                    </Form>
                </div>
            </Col>
        </Row>
    </div>
</template>

<script>
    import AddressAPI from '../../../api/address.js';
    import UserAPI from '../../../api/user.js';
    export default {
        data() {
            return {
                showPrice: false,
                province: [],
                city: [],
                country: [],
                ruleValidate: {
                    username: [
                        { required: true, message: '姓名不能为空', trigger: 'blur' }
                    ],
                    idCard: [
                        { required: true, message: '身份证号码不能为空', trigger: 'blur' }
                    ],
                    blockChainAddress: [
                        { required: true, message: '以太坊地址不能为空', trigger: 'blur' }
                    ],
                    province: [
                        { required: true, message: '省份不能为空', trigger: 'change' }
                    ],
                    city: [
                        { required: true, message: '城市不能为空', trigger: 'change' }
                    ],
                    country: [
                        { required: true, message: '地区不能为空', trigger: 'change' }
                    ],
                }
            }
        },
        mounted: function() {
            this.getProvince();
        },
        methods: {
            /**
             * 提交按钮
             */
            submit: function (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let _this = this;
                        UserAPI.updateInfo(this.user).then( function(response){
                            if(response.data.errCode === 0) {
                                _this.$store.commit('updateInfoSuccess', _this.user);
                                _this.$Message.success('修改成功');
                            } else {
                                _this.$Message.warning(response.data.data);
                            }
                        }).catch( function(){
                            _this.$Message.warning('请求出现异常');
                        });
                    }
                });
            },
            /**
             * 获取省份
             */
            getProvince: function() {
                let _this = this;
                AddressAPI.getProvince().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.province = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取城市
             */
            getCity: function () {
                let _this = this;
                AddressAPI.getCity(this.user.province).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.city = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取地区
             */
            getCountry: function () {
                let _this = this;
                AddressAPI.getCountry(this.user.city).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.country = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            }
        },
        computed: {
            user: function() {
                return this.$store.state.user.userInfo;
            }
        }
    }
</script>