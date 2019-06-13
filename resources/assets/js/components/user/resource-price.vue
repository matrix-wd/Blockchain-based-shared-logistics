<style lang="less">
    @import '../../../less/index.less';
    #resource-price {
        /*label {*/
            /*font-size: 14px !important;*/
        /*}*/
        /*.ivu-form .ivu-form-item-label {*/
            /*font-size: 14px;*/
        /*}*/
    }
</style>

<template>
    <div id="resource-price">
        <Row>
            <Col>
                <Form :model="formItem" ref="formItem" :rules="ruleValidate" :label-width="80">
                    <Row>
                        <Col span="6">
                            <FormItem prop="province" label="省份">
                                <Select v-model="formItem.province" placeholder="请选择省份" filterable @on-change="getCity">
                                    <Option v-for="item in province" :value="item.code">{{item.name}}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6" offset="1">
                            <FormItem prop="city" label="城市">
                                <Select v-model="formItem.city" placeholder="请选择城市" filterable @on-change="getCountry">
                                    <Option v-for="item in city" :value="item.code">{{item.name}}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6" offset="1">
                            <FormItem prop="country" label="地区">
                                <Select v-model="formItem.country" placeholder="请选择地区" filterable>
                                    <Option v-for="item in country" :value="item.name">{{item.name}}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row>
                        <Col span="6">
                            <FormItem label="长(m)" prop="length">
                                <InputNumber v-model="formItem.length" placeholder="请输入长度"></InputNumber>
                            </FormItem>
                        </Col>
                        <Col span="6" offset="1">
                            <FormItem label="宽(m)" prop="width">
                                <InputNumber v-model="formItem.width" placeholder="请输入宽度"></InputNumber>
                            </FormItem>
                        </Col>
                        <Col span="6" offset="1">
                            <FormItem label="高(m)" prop="height">
                                <InputNumber v-model="formItem.height" placeholder="请输入高度"></InputNumber>
                            </FormItem>
                        </Col>
                    </Row>
                    <FormItem label="所属单位" prop="category">
                        <RadioGroup v-model="formItem.category">
                            <Radio label="公司">公司</Radio>
                            <Radio label="个人">个人</Radio>
                        </RadioGroup>
                    </FormItem>
                    <FormItem v-if="conveyanceStatus" label="最大载重" prop="weight">
                        <InputNumber v-model="formItem.weight" placeholder="最大载重"></InputNumber>
                    </FormItem>
                    <FormItem v-if="conveyanceStatus" label="卡车类型" prop="type">
                        <RadioGroup v-model="formItem.type">
                            <Radio label="大货车">大货车</Radio>
                            <Radio label="普通货车">普通货车</Radio>
                            <Radio label="小货车">小货车</Radio>
                            <Radio label="面包车">面包车</Radio>
                            <Radio label="其他">其他</Radio>
                        </RadioGroup>
                    </FormItem>
                    <FormItem v-if="warehouseStatus" label="环境状况">
                        <CheckboxGroup v-model="formItem.environment">
                            <Checkbox label="干燥"></Checkbox>
                            <Checkbox label="通风"></Checkbox>
                        </CheckboxGroup>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" @click="calculate('formItem')" size="large">去估价</Button>
                    </FormItem>
                </Form>
            </Col>
        </Row>
        <Modal
                width="400"
                style="text-align: center"
                v-model="showResult"
                title="估价结果">
            <p><span style="font-weight: 600; color: black; font-size: 40px;">{{finalPrice}}</span> 元/天</p>
            <p style="font-size: 16px;">价格区间：{{minPrice}}元 - {{maxPrice}}元 之间</p>
        </Modal>
    </div>
</template>


<script>
    import AddressAPI from '../../api/address.js';
    import OrderAPI from '../../api/order.js';
    export default {
        data() {
            return {
                showResult: false,
                minPrice: 0,
                maxPrice: 0,
                province: [],
                city: [],
                country: [],
                formItem: {
                    province: '',
                    city: '',
                    country: '',
                    length: null,
                    width: null,
                    height: null,
                    category: '',
                    weight: null,
                    type: '',
                    environment: [],
                },
                ruleValidate: {
                    province: [
                        { required: true, message: '省份不能为空', trigger: 'change' }
                    ],
                    city: [
                        { required: true, message: '城市不能为空', trigger: 'change' }
                    ],
                    country: [
                        { required: true, message: '地区不能为空', trigger: 'change' }
                    ],
                    category: [
                        { required: true, message: '请选择所属单位', trigger: 'blur' }
                    ],
                    type: [
                        { required: true, message: '请选择类别', trigger: 'blur' }
                    ],
                    length: [
                        { required: true, type: 'number', message: '长度不能为空', trigger: 'change' }
                    ],
                    width: [
                        { required: true, type: 'number', message: '宽度不能为空', trigger: 'change' }
                    ],
                    height: [
                        { required: true, type: 'number', message: '高度不能为空', trigger: 'blur' }
                    ],
                    weight: [
                        { required: true, type: 'number', message: '价格不能为空', trigger: 'blur' }
                    ],
                }
            }
        },
        mounted: function() {
            this.getProvince();
        },
        props: {
            warehouseStatus: {
                type: Boolean
            },
            conveyanceStatus: {
                type: Boolean
            }
        },
        methods: {
            /**
             * 估价
             */
            calculate: function(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let _this = this;
                        OrderAPI.calculatePrice(this.formItem).then( function(response){
                            if(response.data.errCode === 0) {
                                _this.minPrice = response.data.minPrice;
                                _this.maxPrice = response.data.maxPrice;
                                _this.showResult = true;
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
                AddressAPI.getCity(this.formItem.province).then( function(response){
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
                AddressAPI.getCountry(this.formItem.city).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.country = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
        },
        computed: {
            /**
             * 最终价格
             * @returns {number}
             */
            finalPrice: function () {
                return ( this.minPrice + this.maxPrice ) / 2;
            }
        }
    }
</script>