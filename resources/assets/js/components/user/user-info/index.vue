<style lang="less">
    @import '../../../../less/index.less';
    @import '../../../../less/user-info.less';
    #user-info-index {

    }
</style>

<template>
    <div id="user-info-index" class="user-info-content-box">
        <Row>
            <Col span="24">
                <h4 class="title">
                    您累计发布了<span class="number">{{totalNumber}}</span>个资源
                </h4>
                <Tabs @on-click="getData">
                    <TabPane label="运输资源">
                        <Item :parent="parent" :items="itemsData" :conveyanceStatus="showCondition"></Item>
                    </TabPane>
                    <TabPane label="仓储资源">
                        <Item :parent="parent" :items="itemsData" :warehouseStatus="showCondition"></Item>
                    </TabPane>
                </Tabs>
                <!--<template v-for="n in 10">-->
                    <!--<Item :showChangePrice="showPrice"></Item>-->
                <!--</template>-->
            </Col>
        </Row>
    </div>
</template>

<script>
    import ConveyanceAPI from '../../../api/conveyance.js';
    import WarehouseAPI from '../../../api/warehouse.js';
    import Item from './item.vue';
    export default {
        data() {
            return {
                userId: 0,
                parent: 'index',
                showCondition: true,
                itemsData: []
            }
        },
        /**
         * 获取数据
         */
        mounted: function() {
            let _this = this;
            setTimeout(function(){
                _this.userId = _this.$store.state.user.userInfo.userId;
                _this.getConveyanceData();
            }, 50);
        },
        computed: {
            totalNumber: function () {
                return this.itemsData.length;
            }
        },
        methods: {
            /**
             * 获取数据
             */
            getData: function (name) {
                if(name === 0) {
                    this.getConveyanceData();
                } else if(name === 1) {
                    this.getWarehouseData();
                }
            },
            /**
             * 获取运输资源数据
             */
            getConveyanceData: function () {
                let _this = this;
                ConveyanceAPI.getDataByUserId(this.userId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.itemsData = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取仓储资源数据
             */
            getWarehouseData: function () {
                let _this = this;
                WarehouseAPI.getDataByUserId(this.userId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.itemsData = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            }
        },
        components: {
            Item
        }
    }
</script>