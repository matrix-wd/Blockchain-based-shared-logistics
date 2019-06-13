<style lang="less">
    @import '../../../less/index.less';
    #orderItem {
        .item {
            height: 240px;
            margin-top: 50px;
            .img-box {
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
    <div id="orderItem">
        <Row class="blank-box" v-if="showBlank">
            暂时没有订单
        </Row>
        <Row v-else class="item" v-for="item in items">
            <Col span="8" class="img-box">
                <img @click="lookInfo(item)" :src="item.imagePath.split(';')[0]" class="item-img" alt="item-image" />
            </Col>
            <Col offset="1" span="15" class="item-info">
                <h4 @click="lookInfo(item)" class="item-title">{{item.title}}</h4>
                <p class="price">
                    <span class="number">{{item.price}}</span>
                    (约{{(item.price / priceUsd).toFixed(5)}}Ether)
                    <span v-if="warehouseStatus">/天/平米</span>
                    <span v-else>/千米/平米</span>
                </p>
                <ul class="list-info">
                    <li><span class="key">买家</span>{{item.buyer.slice(0, 3) + '***' + item.buyer.slice(7, 11)}}</li>
                    <li><span class="key">租用面积</span>{{item.area}}平米</li>
                    <li v-if="warehouseStatus"><span class="key">租用时间段</span>{{item.startDate}} ～ {{item.endDate}}</li>
                    <li><span class="key">订单时间</span>{{item.created_at}}</li>
                    <li><span class="key">总金额</span>{{item.amount}}元(约{{(item.amount / priceUsd).toFixed(5)}}Ether)</li>
                    <li v-if="conveyanceStatus" class="address"><span class="key">目的地</span>{{item.province}}{{item.city}}{{item.country}}{{item.address}}</li>
                    <li>
                        <Button class="btn" type="primary" @click="rentItem(item)">预约</Button>
                    </li>
                </ul>
            </Col>
        </Row>
        <userModal v-if="showModal" :type="type" :item="item"></userModal>
    </div>
</template>

<script>
    import userModal from '../../components/user/user-modal.vue';
    import UserAPI from '../../api/user.js';

    export default {
        data() {
            return {
                item: {}
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
             * 查看详细信息
             * @param item
             */
            lookInfo: function (item) {
                if(this.conveyanceStatus) {
                    localStorage.setItem("resourceId", item.conveyanceId);
                    localStorage.setItem("type", "conveyance");
                } else if(this.warehouseStatus) {
                    localStorage.setItem("resourceId", item.warehouseId);
                    localStorage.setItem("type", "warehouse");
                }
                this.$router.push('/resourceInfo');
            }
        },
        props: {
            items: {
                type: Array
            },
            conveyanceStatus: {
                type: Boolean,
                default: false
            },
            warehouseStatus: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            showBlank: function () {
                if(this.items.length === 0) {
                    return true;
                }
                return false;
            },
            userId: function() {
                return this.$store.state.user.userInfo.userId;
            },
            priceUsd: function () {
                return this.$store.state.home.priceUsd;
            },
            showModal: function () {
                return this.$store.state.user.userModal;
            },
            type: function () {
                if(this.conveyanceStatus) {
                    return 'conveyance';
                }
                return 'warehouse';
            }
        },
        components: {
            userModal
        }
    }
</script>