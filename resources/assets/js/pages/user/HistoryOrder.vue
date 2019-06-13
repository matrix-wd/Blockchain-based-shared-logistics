<style lang="less">
    @import '../../../less/index.less';
    #historyOrder {
        .history-info {
            margin-bottom: 40px;
        }
        .page-box {
            float: right;
            padding: 40px 0;
        }
    }
</style>

<template>
    <div id="historyOrder">
        <Row>
            <Col span="24">
                <headerTitle :title="title" :info="info"></headerTitle>
            </Col>
        </Row>
        <Row class="history-info">
            <Col offset="2" span="20">
                <orderItem :warehouseStatus="warehouseStatus" :conveyanceStatus="conveyanceStatus" :items="items"></orderItem>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <Page :current="currentPage" class="page-box" @on-change="changePage" :page-size="pageSize" :total="totalNumber"></Page>
            </Col>
        </Row>
        <BackTop class="back-top"></BackTop>
        <userFooter></userFooter>
    </div>
</template>


<script>

    import WarehouseOrderAPI from '../../api/warehouseOrder.js';
    import ConveyanceOrderAPI from '../../api/conveyanceOrder.js';
    import headerTitle from '../../components/user/header-title.vue';
    import userFooter from '../../components/user/user-footer.vue';
    import orderItem from '../../components/user/order-item.vue';
    export default {
        data() {
            return {
                currentPage: 1,
                pageSize: 20,
                totalNumber: 200,
                warehouseStatus: false,
                conveyanceStatus: false,
                itemsData: [],
                items: [],
                title: '历史订单',
                info: '骆驼每天有1000+的成交订单'
            }
        },
        mounted: function() {
            let _this = this;
            setTimeout(function(){
                let type = _this.$store.state.order.orderType;
                if(type === 'warehouse') {
                    _this.getWarehouseOrderData();
                } else {
                    _this.getConveyanceOrderData();
                }
            }, 50);
        },
        methods: {
            changePage: function(page) {
                this.currentPage = page;
                let start = ( this.currentPage - 1 ) * this.pageSize;
                this.items = this.itemsData.slice(start, this.pageSize + start);
            },
            /**
             * 获取仓储订单数据
             */
            getWarehouseOrderData: function () {
                let _this = this;
                WarehouseOrderAPI.getOrderData().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.warehouseStatus = true;
                        _this.itemsData = response.data.data;
                        _this.totalNumber = response.data.data.length;
                        let start = ( _this.currentPage - 1 ) * _this.pageSize;
                        _this.items = response.data.data.slice(start, _this.pageSize);
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取运输订单数据
             */
            getConveyanceOrderData: function () {
                let _this = this;
                ConveyanceOrderAPI.getOrderData().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.conveyanceStatus = true;
                        _this.itemsData = response.data.data;
                        _this.totalNumber = response.data.data.length;
                        let start = ( _this.currentPage - 1 ) * _this.pageSize;
                        _this.items = response.data.data.slice(start, _this.pageSize);
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            }
        },
        components: {
            headerTitle,
            orderItem,
            userFooter
        }
    }
</script>