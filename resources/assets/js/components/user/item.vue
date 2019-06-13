<style lang="less">
    @import '../../../less/index.less';
    #item {
        .item {
            height: 240px;
            margin-top: 50px;
            .img-box {
                text-align: center;
                .item-img {
                    cursor: pointer;
                    max-width: 100%;
                    height: 240px;
                }
            }
            .item-info {
                .item-title {
                    cursor: pointer;
                    font-size: 18px;
                    color: #000;
                    font-weight: 600;
                }
                .price {
                    position: relative;
                    top: 60px;
                    right: 20px;
                    float: right;
                    font-size: 14px;
                    .number {
                        font-size: 60px;
                        font-weight: 600;
                        color: #d34844;
                    }
                }
                .list-info {
                    font-size: 14px;
                    list-style: none;
                    margin-top: 20px;
                    li {
                        margin-top: 12px;
                        .key {
                            display: inline-block;
                            color: #888;
                            width: 120px;
                        }
                        .btn {
                            margin-right: 30px;
                        }
                    }
                }
            }
        }
        .blank-box {
            font-size: 16px;
            padding: 30px 0 0 0;
            text-align: center;
        }
    }
</style>

<template>
    <div id="item">
        <Row class="blank-box" v-if="showBlank">
            暂时没有发现资源
        </Row>
        <Row v-else class="item" v-for="(item, index) in items">
            <Col span="8" class="img-box">
                <img @click="lookInfo(item)" :src="item.imagePath.split(';')[0]" class="item-img" alt="item-image" />
            </Col>
            <Col offset="1" span="15" class="item-info">
                <h4 @click="lookInfo(item)" class="item-title">{{item.title}}</h4>
                <p class="price"><span class="number">{{item.price}}</span>(约{{(item.price / priceUsd).toFixed(5)}}Ether){{unitName}}</p>
                <ul class="list-info">
                    <li><span class="key">长*宽*高(米)</span>{{item.length}}*{{item.width}}*{{item.height}}</li>
                    <li><span class="key">总面积</span>{{item.length * item.width}}平米</li>
                    <li v-if="conveyanceStatus"><span class="key">最大载重</span>{{item.maxWeight}}吨</li>
                    <li v-if="warehouseStatus"><span class="key">环境状况</span>{{item.environment}}</li>
                    <li><span class="key">所属单位</span>{{item.category}}</li>
                    <li class="address"><span class="key">地址</span>{{item.province}}{{item.city}}{{item.country}}{{item.address}}</li>
                    <li v-if="conveyanceStatus">
                        <Button class="btn" v-if="item.attentioned > 0" type="primary" @click="cancelAttentionItem(item, index)">取消关注</Button>
                        <Button class="btn" v-else type="primary" @click="attentionItem(item, index)">关注</Button>
                        <Button class="btn" type="primary" @click="rentItem(item)">预约</Button>
                    </li>
                    <li v-if="warehouseStatus">
                        <Button class="btn" v-if="item.attentioned > 0" type="primary" @click="cancelAttentionItem(item, index)">取消关注</Button>
                        <Button class="btn" v-else type="primary" @click="attentionItem(item, index)">关注</Button>
                        <Button class="btn" type="primary" @click="rentItem(item)">预约</Button>
                    </li>
                </ul>
            </Col>
        </Row>
        <userModal v-if="showModal" :type="type" :item="item"></userModal>
    </div>
</template>

<script>
    import AttentionAPI from '../../api/attention.js';
    import UserAPI from '../../api/user.js';
    import userModal from './user-modal.vue';
    export default {
        data() {
            return {
                startDate: '',
                endDate: '',
                content: '',
                area: null,
                province: '',
                city: '',
                country: '',
                item: {},
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
             * 租用
             */
            rentItem: function(item) {
                this.infoStatus();
                this.item = item;
                this.$store.commit('showUserModal');
            },
            /**
             * 关注
             */
            attentionItem: function(item, index) {
                let _this = this;
                let id = null;
                if(this.warehouseStatus) {
                    id = item.warehouseId;
                } else {
                    id = item.conveyanceId;
                }
                AttentionAPI.addAttention(this.userId, id, this.type).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('关注成功');
                        _this.items[index].attentioned = 1;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 取消关注
             * @param id
             */
            cancelAttentionItem: function (item, index) {
                let _this = this;
                let id = null;
                if(this.warehouseStatus) {
                    id = item.warehouseId;
                } else {
                    id = item.conveyanceId;
                }
                AttentionAPI.cancelAttention(this.userId, id, this.type).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('取消关注成功');
                        _this.items[index].attentioned = 0;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 查看详细信息
             * @param item
             */
            lookInfo: function (item) {
                if(this.conveyanceStatus) {
                    localStorage.setItem("resourceId", item.conveyanceId);
                } else if(this.warehouseStatus) {
                    localStorage.setItem("resourceId", item.warehouseId);
                }
                localStorage.setItem("type", this.type);
                this.$router.push('/resourceInfo');
            }
        },
        props: {
            items: {
                type: Array
            },
            conveyanceStatus: {
                type: Boolean,
                default: function() {
                    return false;
                }
            },
            warehouseStatus: {
                type: Boolean,
                default: function () {
                    return false;
                }
            }
        },
        computed: {
            showBlank: function () {
                if(this.items.length === 0) {
                    return true;
                }
                return false;
            },
            unitName: function () {
                if(this.conveyanceStatus) {
                    return '/平米/千米';
                }
                return '/平米/天';
            },
            userId: function() {
                return this.$store.state.user.userInfo.userId;
            },
            type: function () {
                if(this.warehouseStatus) {
                    return 'warehouse';
                } else {
                    return 'conveyance';
                }
            },
            showModal: function () {
                return this.$store.state.user.userModal;
            },
            priceUsd: function () {
                return this.$store.state.home.priceUsd;
            }
        },
        components: {
            userModal
        }
    }
</script>