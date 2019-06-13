<style lang="less">
    @import '../../../less/index.less';
    #userInfo {
        .user-info {
            margin: 50px 0;
            .menu-box {
                min-width: 170px;
                height: 500px;
                border: 1px solid #ccc;
                box-shadow: 1px 1px 1px #ccc;
                .photo {
                    margin-top: 30px;
                    text-align: center;
                    .photo-img {
                        width: 100px;
                    }
                    p {
                        padding: 15px 0;
                        font-size: 14px;
                    }
                }
                .menu-ul {
                    padding-top: 20px;
                    //width: 100%;
                    list-style: none;
                    font-size: 14px;
                    li {
                        padding-left: 40px;
                        width: 100%;
                        height: 40px;
                        line-height: 40px;
                        cursor: pointer;
                    }
                    .active {
                        background: @primary-color;
                        color: white;
                    }
                }
            }
            .content-box {
                min-width: 700px;
                min-height: 700px;
                border: 1px solid #ccc;
                box-shadow: 1px 1px 1px #ccc;
            }
        }
    }
</style>
<template>
    <div id="userInfo">
        <userHeader></userHeader>
        <Row class="user-info">
            <Col span="3" offset="3" class="menu-box">
                <div class="photo">
                    <img src="../../../img/photo.png" class="photo-img" alt="photo-img" />
                    <p>欢迎您，{{telephone}}</p>
                </div>
                <ul class="menu-ul">
                    <li :class="{active: shows.index}" @click="showIndex">我的资源</li>
                    <li :class="{active: shows.rent}" @click="showRent">资源出租订单</li>
                    <li :class="{active: shows.resource}" @click="showAttentionedResource">我的关注</li>
                    <li :class="{active: shows.order}" @click="showOrder">资源租用订单</li>
                    <!--<li :class="{active: shows.conveyance}" @click="showConveyance">关注的运输资源</li>-->
                    <!--<li :class="{active: shows.conveyanceOrder}" @click="showConveyanceOrder">运输订单</li>-->
                    <!--<li :class="{active: shows.warehouseOrder}" @click="showWarehouseOrder">仓储订单</li>-->
                    <li :class="{active: shows.info}" @click="showInfo">完善信息</li>
                    <li :class="{active: shows.password}" @click="showPassword">修改密码</li>
                </ul>
            </Col>
            <Col span="14" offset="1" class="content-box">
                <Index v-if="shows.index"></Index>
                <Resource v-if="shows.resource"></Resource>
                <!--<Conveyance v-if="shows.conveyance"></Conveyance>-->
                <!--<conveyanceOrder v-if="shows.conveyanceOrder"></conveyanceOrder>-->
                <!--<warehouseOrder v-if="shows.warehouseOrder"></warehouseOrder>-->
                <Rent v-if="shows.rent"></Rent>
                <Order v-if="shows.order"></Order>
                <Info v-if="shows.info"></Info>
                <Password v-if="shows.password"></Password>
            </Col>
        </Row>
        <userModal v-if="showModal" :type="type" :item="item"></userModal>
    </div>
</template>

<script>
    import UserAPI from '../../api/user.js';
    import userHeader from '../../components/user/user-header.vue';
    import Index from '../../components/user/user-info/index.vue';
    import Resource from '../../components/user/user-info/resource.vue';
    import Order from '../../components/user/user-info/order.vue';
    import Rent from '../../components/user/user-info/rent.vue';
    // import Warehouse from '../../components/user/user-info/warehouse.vue';
    // import Conveyance from '../../components/user/user-info/conveyance.vue';
    // import conveyanceOrder from '../../components/user/user-info/conveyance-order.vue';
    // import warehouseOrder from '../../components/user/user-info/warehouse-order.vue';
    import Info from '../../components/user/user-info/info.vue';
    import Password from '../../components/user/user-info/password.vue';
    import userModal from '../../components/user/user-modal.vue';
    export default {
        data() {
            return {
                shows: {
                    index: true,
                    resource: false,
                    order: false,
                    rent: false,
                    // conveyance: false,
                    // conveyanceOrder: false,
                    // warehouseOrder: false,
                    info: false,
                    password: false
                }
            }
        },
        mounted: function() {
            let _this = this;
            UserAPI.loginStatus().then( function(response){
                if(response.data.errCode === -1) {
                    _this.$Message.warning('请先登录');
                    _this.$router.back();
                }
            }).catch( function(){
                _this.$Message.warning('请求出现异常');
            });
        },
        methods: {
            showIndex: function () {
                this.hiddenAll();
                this.shows.index = true;
            },
            showAttentionedResource: function () {
                this.hiddenAll();
                this.shows.resource = true;
            },
            showOrder: function() {
                this.hiddenAll();
                this.shows.order = true;
            },
            // showConveyance: function () {
            //     this.hiddenAll();
            //     this.shows.conveyance = true;
            // },
            // showConveyanceOrder: function() {
            //     this.hiddenAll();
            //     this.shows.conveyanceOrder = true;
            // },
            // showWarehouseOrder: function() {
            //     this.hiddenAll();
            //     this.shows.warehouseOrder = true;
            // },
            showInfo: function() {
                this.hiddenAll();
                this.shows.info = true;
            },
            showRent: function() {
                this.hiddenAll();
                this.shows.rent = true;
            },
            showPassword: function() {
                this.hiddenAll();
                this.shows.password = true;
            },
            /**
             * 隐藏全部
             */
            hiddenAll: function () {
                for(let key in this.shows) {
                    this.shows[key] = false;
                }
            }
        },
        computed: {
            telephone: function() {
                let telephone = this.$store.state.user.userInfo.telephone;
                if(telephone) {
                    return telephone.slice(0, 3) + '***' + telephone.slice(7, 11);
                }
                return telephone;
            },
            returnIndex: function () {
                if(this.$store.state.user.returnIndex === true) {
                    alert(1);
                    this.$router.back();
                }
                return true;
            },
            showModal: function () {
                return this.$store.state.user.userModal;
            },
            type: function () {
                return this.$store.state.resource.type;
            },
            item: function () {
                return this.$store.state.resource.item;
            }
        },
        components: {
            userHeader,
            Index,
            Resource,
            Order,
            Rent,
            userModal,
            // Warehouse,
            // Conveyance,
            // conveyanceOrder,
            // warehouseOrder,
            Info,
            Password
        }
    }
</script>