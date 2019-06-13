<style lang="less">
    @import '../../../less/index.less';
    #user-modal {
        padding: 10px 30px 30px 30px;
        color: black;
        position: fixed;
        z-index: 999;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        width: 420px;
        height: 300px;
        margin: auto;
        background-color: white;
        border-radius: 5px;
        h4 {
            padding-top: 20px;
        }
        .row-box {
            margin-top: 20px;
            .btn {
                margin-right: 16px;
            }
        }
    }
    .userModal {
        height: 350px !important;
    }
</style>

<template>
    <div id="user-modal" :class="{userModal: type === 'conveyance'}">
        <h4>填写租用信息</h4>
        <Row v-if=" type === 'warehouse' " class="row-box">
            <DatePicker placeholder="租用开始时间" @on-change="startDateChange"></DatePicker> ～
            <DatePicker placeholder="租用结束时间" @on-change="endDateChange"></DatePicker>
        </Row>
        <Row class="row-box" v-if=" type === 'conveyance' ">
            <Select v-model="province" placeholder="省份" style="width:110px" class="select-box" filterable @on-change="getCity">
                <Option v-for="item in provinces" :value="item.code">{{item.name}}</Option>
            </Select>
            <Select v-model="city" placeholder="城市" style="width:110px; margin-left: 10px" class="select-box" filterable @on-change="getCountry">
                <Option v-for="item in citys" :value="item.code">{{item.name}}</Option>
            </Select>
            <Select v-model="country" placeholder="地区" style="width:110px; margin-left: 10px" class="select-box" filterable>
                <Option v-for="item in countrys" :value="item.name">{{item.name}}</Option>
            </Select>
        </Row>
        <Row class="row-box" v-if=" type === 'conveyance' ">
            <Input v-model="address" placeholder="请选择目的地详细地址"></Input>
        </Row>
        <Row class="row-box">
            <Input v-model="content" placeholder="请输入存储物品"></Input>
        </Row>
        <Row class="row-box">
            <InputNumber v-model="area" :min="1" placeholder="请输入租用面积"></InputNumber>
            <Button v-if=" type === 'conveyance' " type="primary" style="float: right; margin-right: 30px" class="btn" @click="getDistanceData('click')">计算距离</Button>
        </Row>
        <Row class="row-box">
            <Button type="primary" class="btn" @click="cancel">取消</Button>
            <Button type="primary" class="btn" @click="rentItem">提交</Button>
        </Row>
    </div>
</template>

<script>

    import WarehouseOrderAPI from '../../api/warehouseOrder.js';
    import ConveyanceOrderAPI from '../../api/conveyanceOrder.js';
    import UserAPI from '../../api/user.js';
    import { Map } from '../../map.js';
    import AddressAPI from '../../api/address.js';
    export default {
        data() {
            return {
                provinces: [],
                citys: [],
                countrys: [],
                distance: null,
                startDate: '',
                address: '',
                endDate: '',
                content: '',
                area: null,
                province: '',
                city: '',
                country: '',
            }
        },
        mounted: function() {
            this.getProvince();
        },
        methods: {
            /**
             * 租用
             */
            rentItem: function() {
                if(this.item.usedStatus === '0') {
                    this.$Message.warning('该资源已经下架');
                } else if(this.item.checkedStatus !== '1') {
                    this.$Message.warning('该资源修改信息后还未通过审核');
                } else {
                    if(this.type === 'warehouse') {
                        if(this.checkWarehouse()) {
                            this.rentWarehouse();
                        }
                    } else {
                        if(this.checkConveyance()) {
                            this.rentConveyance();
                        }
                    }
                }
            },
            /**
             * 取消按钮
             */
            cancel: function() {
                this.$store.dispatch('maskAction');
            },
            /**
             * 租用运输资源
             */
            async rentConveyance() {
                if(this.distance === null) {
                    await this.getDistanceData('auto');
                }
                let _this = this;
                ConveyanceOrderAPI.rentItem(this.userId, this.item.conveyanceId,  this.province, this.city, this.country, this.address, this.area, this.distance, this.item.price, this.content).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('预约成功，请等待资源方同意后在我的订单中付款');
                        _this.$store.dispatch('maskAction');
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取计算结果
             */
            async getDistanceData(type) {
                this.$Spin.show();
                let targetAddress = this.province + '' + this.city + '' + this.country + '' + this.address;
                let resourceAddress = this.item.province + '' + this.item.city + '' + this.item.country + '' + this.item.address;
                let targetLocation = await this.getLocation(targetAddress);
                let resourceLocation = await this.getLocation(resourceAddress);
                if(targetLocation === 'error' || resourceLocation === 'error') {
                    this.$Message.warning('距离计算出现问题');
                } else {
                    let distance = await this.calculateDistance(targetLocation, resourceLocation);
                    distance = Math.round(distance / 1000);
                    this.distance = distance;
                    this.$Spin.hide();
                    if(type !== 'auto') {
                        this.$Modal.info({
                            title: '距离',
                            content: '约 ' + distance + ' 千米'
                        });
                    }
                }
            },
            /**
             * 计算距离
             */
            async calculateDistance(targetLocation, resourceLocation) {
                return new Promise(function (resolve, reject) {
                    Map().then(AMap => {
                        let distance = AMap.GeometryUtil.distance(targetLocation, resourceLocation);
                        return resolve(distance);
                    }).catch(function (error) {
                        return reject(error);
                    });
                });
            },
            /**
             * 获取经纬度
             */
            getLocation: function(address) {
                return new Promise(function (resolve, reject) {
                    Map().then(AMap => {
                        let geocoder = new AMap.Geocoder({
                            // city: "010", //城市设为北京，默认：“全国”
                        });
                        geocoder.getLocation(address, function(status, result) {
                            if (status === 'complete' && result.geocodes.length) {
                                let res = [result.geocodes[0].location.lng, result.geocodes[0].location.lat];
                                return resolve(res);
                            } else {
                                return reject('error');
                            }
                        });
                    });
                });
            },
            /**
             * 租用仓储资源
             */
            rentWarehouse: function() {
                let _this = this;
                WarehouseOrderAPI.rentItem(this.userId, this.item.warehouseId, this.startDate, this.endDate, this.area, this.item.price, this.content).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('预约成功，请等待资源方同意后在我的订单中付款');
                        _this.$store.dispatch('maskAction');
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 开始时间是否符合要求
             * @param val
             */
            startDateChange: function (val) {
                this.startDate = val;
                if((new Date(val).getTime() + (24*60*60*1000)) < Date.now()) {
                    this.$Message.warning('租用时间不得小于今天');
                }
            },
            /**
             * 结束时间是否符合要求
             */
            endDateChange: function (val) {
                this.endDate = val;
                if(this.startDate > this.endDate) {
                    this.$Message.warning('结束时间不得小于开始时间');
                }
            },
            /**
             * 检测是否通过
             * @returns {boolean}
             */
            checkWarehouse: function () {
                if(this.startDate > this.endDate) {
                    this.$Message.warning('结束时间不得小于开始时间');
                    return false;
                }
                if(this.content === '') {
                    this.$Message.warning('请输入仓储物品');
                    return false;
                }
                if(this.area === null || this.area === 0) {
                    this.$Message.warning('租用面积不得小于零');
                    return false;
                }
                return true;
            },
            /**
             * 检查是否通过
             */
            checkConveyance: function() {
                if(this.province === '') {
                    this.$Message.warning('省份不能为空');
                    return false;
                }
                if(this.city === '') {
                    this.$Message.warning('城市不能为空');
                    return false;
                }
                if(this.country === '') {
                    this.$Message.warning('地区不能为空');
                    return false;
                }
                if(this.content === '') {
                    this.$Message.warning('请输入仓储物品');
                    return false;
                }
                if(this.area === null || this.area === 0) {
                    this.$Message.warning('租用面积不得小于零');
                    return false;
                }
                return true;
            },
            /**
             * 获取省份
             */
            getProvince: function() {
                let _this = this;
                AddressAPI.getProvince().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.provinces = response.data.data;
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
                AddressAPI.getCity(this.province).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.citys = response.data.data;
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
                AddressAPI.getCountry(this.city).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.countrys = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
        },
        props: {
            type: {
                type: String
            },
            item: {
                type: Object
            }
        },
        computed: {
            userId: function() {
                return this.$store.state.user.userInfo.userId;
            },
        }
    }
</script>