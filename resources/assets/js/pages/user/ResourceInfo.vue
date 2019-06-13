<style lang="less">
    @import '../../../less/index.less';
    #warehouse-info {
        .title-box {
            background-color: #eee;
            h4 {
                font-weight: 600;
                color: black;
                padding: 40px 0 20px 0;
            }
            .description {
                padding-bottom: 40px;
                font-size: 16px;
            }
        }
        .info-box {
            margin-top: 50px;
            .demo-carousel {
                height: 350px;
                img {
                    max-width: 98%;
                    height: 100%;
                }
            }
            .basic-info {
                .price {
                    font-size: 18px;
                    span {
                        font-size: 28px;
                        color: @primary-color;
                        font-weight: 600;
                    }
                }
                padding-left: 40px;
                .area-ul {
                    list-style: none;
                    font-size: 14px;
                    li {
                        /*border: 1px solid red;*/
                        float: left;
                        width: 50%;
                        margin-bottom: 20px;
                    }
                    .address {
                        width: 100%;
                    }
                    .key {
                        display: inline-block;
                        color: #888;
                        width: 90px;
                    }
                    .btn {
                        margin-right: 30px;
                    }
                }
            }
        }
        .recommend-box {
            h4 {
                font-weight: 600;
                color: black;
            }
        }
    }
</style>

<template>
    <div id="warehouse-info">
        <userHeader></userHeader>
        <Row class="title-box">
            <Col span="20" offset="2">
                <h4>{{item.title}}</h4>
                <p class="description">{{item.description}}</p>
            </Col>
        </Row>
        <Row class="info-box">
            <Col span="10" offset="2" style="text-align: center">
                <Carousel v-model="value" autoplay loop>
                    <CarouselItem v-for="src in images">
                        <div class="demo-carousel">
                            <img :src="src" alt="warehouse" />
                        </div>
                    </CarouselItem>
                </Carousel>
            </Col>
            <Col span="10" class="basic-info">
                <p class="price">均价：<span>{{item.price}}</span>(约{{(item.price / priceUsd).toFixed(5)}}Ether){{unitName}}</p>
                <Divider />
                <ul class="area-ul">
                    <li><span class="key">长*宽*高(米)</span>{{item.length}}*{{item.width}}*{{item.height}}</li>
                    <li><span class="key">总面积</span>{{item.length * item.width}}平米</li>
                    <li v-if="type==='warehouse'"><span class="key">数量</span>{{item.number}}</li>
                    <li v-if="type==='warehouse'"><span class="key">环境状况</span>{{item.environment}}</li>
                    <li v-if="type==='conveyance'"><span class="key">类型</span>{{item.type}}</li>
                    <li v-if="type==='conveyance'"><span class="key">最大载重</span>{{item.maxWeight}}吨</li>
                    <li><span class="key">所属单位</span>{{item.category}}</li>
                    <li><span class="key">联系电话</span>15739081232</li>
                    <li class="address"><span class="key">地址</span>{{item.province}}{{item.city}}{{item.country}}{{item.address}}</li>
                    <Button class="btn" v-if="item.attentioned > 0" type="primary" @click="cancelAttentionItem(item)">取消关注</Button>
                    <Button class="btn" v-else type="primary" @click="attentionItem(item)">关注</Button>
                    <Button class="btn" type="primary" @click="rentItem(item)">预约</Button>
                </ul>
            </Col>
        </Row>
        <userModal v-if="showModal" :type="type" :item="rentCurrentItem"></userModal>
        <reserveInfo :items="reserveData" :type="type"></reserveInfo>
        <userMap :address="detailAddress"></userMap>
        <orderInfo :items="orderData"></orderInfo>
        <Row class="recommend-box">
            <Col span="20" offset="2">
                <h4>{{title}}</h4>
                <fourCard :type="type" :data="recommendData"></fourCard>
            </Col>
        </Row>
        <userFooter></userFooter>
    </div>
</template>


<script>
    import ConveyanceAPI from '../../api/conveyance.js';
    import WarehouseAPI from '../../api/warehouse.js';
    import AttentionAPI from '../../api/attention.js';
    import Tools_API from '../../api/tools.js';
    import UserAPI from '../../api/user.js';
    import WarehouseOrderAPI from '../../api/warehouseOrder.js';
    import ConveyanceOrderAPI from '../../api/conveyanceOrder.js';
    import userHeader from '../../components/user/user-header.vue';
    import orderInfo from '../../components/user/order-info.vue';
    import reserveInfo from '../../components/user/reserve-info.vue';
    import fourCard from '../../components/card/four-card.vue';
    import userModal from '../../components/user/user-modal.vue';
    import userMap from '../../components/user/user-map.vue';
    import userFooter from '../../components/user/user-footer.vue';

    export default {
        data() {
            return {
                startDate: '',
                endDate: '',
                area: null,
                result: 8,
                moreStatus: false,
                value: 0,
                type: '',
                orderData: [],
                reserveData: [],
                recommendData: [],
                images: [],
                resourceId: 0,
                item: {},
                rentCurrentItem: {},
            }
        },
        mounted: function() {
            this.resourceId = localStorage.getItem("resourceId");
            this.type = localStorage.getItem("type");
            if(this.type === 'warehouse') {
                this.getWarehouseInfo();
                this.getWarehouseOrderInfo();
                this.getWarehouseReserveData();
                this.getRecommendWarehouseData();
            } else if(this.type === 'conveyance') {
                this.getConveyanceInfo();
                this.getConveyanceOrderInfo();
                this.getConveyanceReserveData();
                this.getRecommendConveyanceData();
            }
        },
        methods: {
            /**
             * 判断用户的信息是否已经完善
             */
            infoStatus: function () {
                let userId = this.$store.state.user.userInfo.userId;
                let _this = this;
                UserAPI.getUserInfoStatus(userId).then( function(response){
                    if(response.data.data === '0') {
                        _this.$Message.warning('请先完善个人信息');
                        _this.$router.push('/userInfo');
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
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
             * 获取仓储资源预定数据
             */
            getWarehouseReserveData: function() {
                let _this = this;
                WarehouseOrderAPI.getReserveData(this.resourceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.reserveData = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取运输资源预定数据
             */
            getConveyanceReserveData: function() {
                let _this = this;
                ConveyanceOrderAPI.getReserveData(this.resourceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.reserveData = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取推荐运输数据
             */
            getRecommendConveyanceData: function () {
                let _this = this;
                ConveyanceOrderAPI.getRecommendData(8).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.recommendData = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 推荐仓储资源
             */
            getRecommendWarehouseData: function() {
                let _this = this;
                WarehouseOrderAPI.getRecommendData(8).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.recommendData = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             *  获取仓储资源的详细信息
             **/
            getWarehouseInfo: function() {
                let _this = this;
                WarehouseAPI.getInfo(this.resourceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.item = response.data.data;
                        _this.images = response.data.data.imagePath.split(';');
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             *  获取运输资源的详细信息
             */
            getConveyanceInfo: function() {
                let _this = this;
                ConveyanceAPI.getInfo(this.resourceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.item = response.data.data;
                        _this.images = response.data.data.imagePath.split(';');
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取运输资源订单信息
             */
            getConveyanceOrderInfo: function () {
                let _this = this;
                ConveyanceAPI.getConveyanceOrderInfo(this.resourceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.orderData = response.data.data;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取仓储资源订单信息
             */
            getWarehouseOrderInfo: function() {
                let _this = this;
                WarehouseAPI.getWarehouseOrderInfo(this.resourceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.orderData = response.data.data;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 关注
             * @param item
             */
            attentionItem: function (item) {
                let _this = this;
                let id = null;
                if(this.type === 'warehouse') {
                    id = item.warehouseId;
                } else {
                    id = item.conveyanceId;
                }
                AttentionAPI.addAttention(this.userId, id, this.type).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('关注成功');
                        _this.item.attentioned = 1;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 取消关注
             */
            cancelAttentionItem: function (item) {
                let _this = this;
                let id = null;
                if(this.type === 'warehouse') {
                    id = item.warehouseId;
                } else {
                    id = item.conveyanceId;
                }
                AttentionAPI.cancelAttention(this.userId, id, this.type).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('取消关注成功');
                        _this.item.attentioned = 0;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 租用
             */
            rentItem: function(item) {
                this.infoStatus();
                this.rentCurrentItem = item;
                this.$store.commit('showUserModal');
            },
        },
        components: {
            userHeader,
            orderInfo,
            fourCard,
            reserveInfo,
            userModal,
            userMap,
            userFooter
        },
        computed: {
            /**
             * 单位
             */
            unitName: function () {
                if(this.type === 'conveyance') {
                    return '/平米/千米';
                }
                return '/平米/天';
            },
            /**
             * 详细地址
             * @returns {string}
             */
            detailAddress: function() {
                return this.item.province + '' + this.item.city + '' + this.item.country;
            },
            /**
             * 用户Id
             * @returns {*}
             */
            userId: function () {
                return this.$store.state.user.userInfo.userId;
            },
            /**
             * 展示租用信息框
             * @returns {{data, mounted, methods, props, computed}|boolean}
             */
            showModal: function () {
                return this.$store.state.user.userModal;
            },
            /**
             * 标题
             * @returns {string}
             */
            title: function () {
                if(this.type === 'warehouse') {
                    return '为您推荐优质仓储';
                } else {
                    return '为您推荐优质运输';
                }
            },
            /**
             * 转换率
             * @returns {default.computed.priceUsd|(function())|priceUsd|null}
             */
            priceUsd: function () {
                return this.$store.state.home.priceUsd;
            }
        },
    }
</script>