<style lang="less">
    @import '../../../../less/index.less';
    #createConveyance {
        .form-box {
            margin-bottom: 50px;
            .go-calculate-price {
                position: relative;
                top: 5px;
                font-size: 14px;
                color: @primary-color;
                cursor: pointer;
            }
        }
    }
</style>

<template>
    <div id="createConveyance">
        <Row>
            <Col span="24">
                <headerTitle :title="title" :info="info"></headerTitle>
            </Col>
        </Row>
        <Row class="form-box">
            <Col offset="4" span="16">
                <Form :model="conveyance" ref="conveyance" :rules="ruleValidate"  :label-width="90">
                    <Row>
                        <Col span="6">
                            <FormItem prop="province" label="省份">
                                <Select v-model="conveyance.province" placeholder="请选择省份" filterable @on-change="getCity">
                                    <Option v-for="item in province" :value="item.code">{{item.name}}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6" offset="1">
                            <FormItem prop="city" label="城市">
                                <Select v-model="conveyance.city" placeholder="请选择城市" filterable @on-change="getCountry">
                                    <Option v-for="item in city" :value="item.code">{{item.name}}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6" offset="1">
                            <FormItem prop="country" label="地区">
                                <Select v-model="conveyance.country" placeholder="请选择地区" filterable>
                                    <Option v-for="item in country" :value="item.name">{{item.name}}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                    </Row>
                    <FormItem label="详细地址" prop="address">
                        <Row>
                            <Col span="20">
                                <Input v-model="conveyance.address" placeholder="请输入当前运输资源的详细地址"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem label="卡车类型" prop="type">
                        <RadioGroup v-model="conveyance.type">
                            <Radio label="大货车">大货车</Radio>
                            <Radio label="普通货车">普通货车</Radio>
                            <Radio label="小货车">小货车</Radio>
                            <Radio label="面包车">面包车</Radio>
                            <Radio label="其他">其他</Radio>
                        </RadioGroup>
                    </FormItem>
                    <FormItem label="所属单位" prop="category">
                        <RadioGroup v-model="conveyance.category">
                            <Radio label="公司">公司</Radio>
                            <Radio label="个人">个人</Radio>
                        </RadioGroup>
                    </FormItem>
                    <FormItem v-if="showCompany" label="公司名称">
                        <Row>
                            <Col span="20">
                                <Input v-model="conveyance.company" placeholder="请输入公司名称"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <Row>
                        <Col span="5">
                            <FormItem label="长(m)" prop="length">
                                <InputNumber v-model="conveyance.length" placeholder="请输入长度"></InputNumber>
                            </FormItem>
                        </Col>
                        <Col span="5">
                            <FormItem label="宽(m)" prop="width">
                                <InputNumber v-model="conveyance.width" placeholder="请输入宽度"></InputNumber>
                            </FormItem>
                        </Col>
                        <Col span="5">
                            <FormItem label="高(m)" prop="height">
                                <InputNumber v-model="conveyance.height" placeholder="请输入高度"></InputNumber>
                            </FormItem>
                        </Col>
                        <!--<Col span="5">-->
                            <!--<FormItem label="数量" prop="number">-->
                                <!--<InputNumber :min="1" :step="1" v-model="conveyance.number" placeholder="请输入数量"></InputNumber>-->
                            <!--</FormItem>-->
                        <!--</Col>-->
                    </Row>
                    <Row>
                        <Col span="5">
                            <FormItem label="最大载重" prop="maxWeight">
                                <InputNumber v-model="conveyance.maxWeight" placeholder="请输入最大载重"></InputNumber>
                            </FormItem>
                        </Col>
                        <Col span="5">
                            <FormItem label="价格(/平米/千米)" prop="price">
                                <InputNumber v-model="conveyance.price" placeholder="请输入价格"></InputNumber>
                            </FormItem>
                        </Col>
                        <Col offset="2" span="8">
                            <span class="go-calculate-price" @click="goCalculate">不知道如何定价?去估价</span>
                        </Col>
                    </Row>
                    <FormItem label="标题" prop="title">
                        <Row>
                            <Col span="20">
                                <Input v-model="conveyance.title" placeholder="请输入标题信息"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem label="描述" prop="description">
                        <Row>
                            <Col span="20">
                                <Input v-model="conveyance.description" type="textarea" :autosize="{minRows: 5,maxRows: 8}" placeholder="请输入标题信息"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem label="上传图片">
                        <multipleUpload :uploadList="images" :action="action" :parent="parent"></multipleUpload>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" size="large" @click="submit('conveyance')">提交</Button>
                    </FormItem>
                </Form>
            </Col>
        </Row>
        <userFooter></userFooter>
    </div>
</template>


<script>
    import UserAPI from '../../../api/user.js';
    import AddressAPI from '../../../api/address.js';
    import ConveyanceAPI from '../../../api/conveyance.js';
    import headerTitle from '../../../components/user/header-title.vue';
    import userFooter from '../../../components/user/user-footer.vue';
    import multipleUpload from '../../../components/upload/multiple-upload.vue';
    export default {
        data() {
            return {
                action: 'http://localhost:8081/api/conveyance/uploadFile',
                title: '运输资源',
                info: '感谢您为他人提供运输资源，希望您运输客户的资源向骆驼运输货物一样',
                province: [],
                images: [],
                city: [],
                country: [],
                parent: 'conveyance',
                status: '',
                conveyance: {
                    province: '',
                    city: '',
                    country: '',
                    type: '',
                    address: '',
                    category: '',
                    company: '',
                    length: null,
                    width: null,
                    height: null,
                    number: 1,
                    price: null,
                    maxWeight: null,
                    title: '',
                    description: ''
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
                    address: [
                        { required: true, message: '详细地址不能为空', trigger: 'blur' }
                    ],
                    title: [
                        { required: true, message: '标题不能为空', trigger: 'blur' }
                    ],
                    description: [
                        { required: true, message: '描述不能为空', trigger: 'blur' }
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
                    number: [
                        { required: true, type: 'number', message: '数量不能为空', trigger: 'blur' }
                    ],
                    price: [
                        { required: true, type: 'number', message: '价格不能为空', trigger: 'blur' }
                    ],
                    maxWeight: [
                        { required: true, type: 'number', message: '价格不能为空', trigger: 'blur' }
                    ],
                }
            }
        },
        mounted: function() {
            this.loginStatus();
            let _this = this;
            setTimeout(function(){
                _this.status = _this.$store.state.home.itemStatus;
                if(_this.status === 'update') {
                    _this.conveyance = _this.$store.state.home.updateData;
                    let images = _this.conveyance.imagePath.split(';');
                    for(let i = 0; i < images.length; i++) {
                        _this.images.push({
                           'name': images[i],
                           'url': 'http://localhost:8081/' + images[i],
                            'status': 'finished'
                        });
                    }
                }
                if(Object.keys(_this.$store.state.conveyance.conveyance).length !== 0) {
                    _this.conveyance = _this.$store.state.conveyance.conveyance;
                }
            }, 50);
        },
        methods: {
            /**
             *  提交
             * */
            submit: function(name) {
                if(this.status === 'create') {
                    this.createConveyance(name);
                } else if(this.status === 'update') {
                    this.updateConveyance(name);
                }
            },
            /**
             * 创建运输资源
             */
            createConveyance: function(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let _this = this;
                        ConveyanceAPI.createConveyance(this.conveyance, this.tmpImages).then( function(response){
                            if(response.data.errCode === 0) {
                                _this.$Message.success('创建成功,请等待审核');
                                _this.$router.back();
                            } else {
                                _this.$Message.warning(response.data.data);
                            }
                        }).catch( function(){
                            _this.$Message.warning('请求出现异常');
                        });
                    }
                })
            },
            /**
             *  修改运输资源
             */
            updateConveyance: function(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let _this = this;
                        ConveyanceAPI.updateConveyance(this.conveyance, this.tmpImages).then( function(response){
                            if(response.data.errCode === 0) {
                                _this.$Message.success('修改成功,请等待审核');
                                _this.$router.back();
                            } else {
                                _this.$Message.warning(response.data.data);
                            }
                        }).catch( function(){
                            _this.$Message.warning('请求出现异常');
                        });
                    }
                })
            },
            /**
             * 如果没有登录禁止访问
             * */
            loginStatus: function() {
                let _this = this;
                UserAPI.loginStatus().then( function(response){
                    if(response.data.errCode === -1) {
                        _this.$Message.warning('请先登录');
                        _this.$router.back();
                    } else {
                        _this.getProvince();
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
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
                AddressAPI.getCity(this.conveyance.province).then( function(response){
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
                AddressAPI.getCountry(this.conveyance.city).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.country = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 去估价
             */
            goCalculate: function() {
                this.$store.commit('setConveyanceInfo', this.conveyance);
                this.$router.push('/calculatePrice')
            }
        },
        computed: {
            showCompany: function () {
                if(this.conveyance.category === '个人') {
                    return false;
                }
                return true;
            },
            tmpImages: function () {
                let tmpArray = [];
                for(let i = 0; i < this.images.length; i++) {
                    tmpArray.push(this.images[i].name);
                }
                return tmpArray.join(';');
            }
        },
        components: {
            headerTitle,
            userFooter,
            multipleUpload
        }
    }
</script>