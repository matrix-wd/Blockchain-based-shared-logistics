<style lang="less">
    @import '../../../less/index.less';
    @import '../../../less/service.less';
</style>

<template>
    <div id="warehouse">
        <userHeader></userHeader>
        <Row class="first-row">
            <Col span="20" offset="2">
                <img src="../../../img/logo.png" @click="goHome" class="logo-img" alt="logo" />
                <div class="search-box">
                    <input type="text" v-on:keyup.enter="getSearchData" v-model="condition.searchData" class="user-input" placeholder="请输入运输地址与需求进行查找" />
                    <Icon type="ios-search" @click="getSearchData" class="search-icon" size="26" />
                </div>
                <div class="status">
                    <ul>
                        <li class="active">空闲</li>
                        <li @click="goHistoryOrder">历史订单</li>
                    </ul>
                </div>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <selectCondition :warehouseCondition="showCondition" @getData="getData"></selectCondition>
                <Divider />
            </Col>
        </Row>
        <Row class="select-type-box">
            <Col span="20" offset="2">
                <p class="title-p">
                    共找到<span class="number">{{totalNumber}}</span>个仓储资源
                </p>
                <div class="order-type">
                    <ul>
                        <li :class="{ active: sortMethod.default}" @click="defaultSort">默认排序</li>
                        <li :class="{ active: sortMethod.time}" @click="timeSort">最新</li>
                        <li :class="{ active: sortMethod.price}" @click="priceSort">
                            价格
                            <Icon :type="'ios-arrow-round-' + priceSortStatus" />
                        </li>
                        <!--<li :class="{ active: sortMethod.area}" @click="areaSort">-->
                            <!--面积-->
                            <!--<Icon :type="'ios-arrow-round-' + areaSortStatus" />-->
                        <!--</li>-->
                    </ul>
                </div>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <Item :items="itemsData" :warehouseStatus="showCondition"></Item>
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
    import WarehouseAPI from '../../api/warehouse.js';
    import userHeader from '../../components/user/user-header.vue';
    import Item from '../../components/user/item.vue';
    import selectCondition from '../../components/user/select-condition.vue';
    import userFooter from '../../components/user/user-footer.vue';
    export default {
        data() {
            return {
                pageSize: 25,
                currentPage: 1,
                totalNumber: 0,
                showCondition: true,
                priceSortStatus: 'up',
                areaSortStatus: 'up',
                // searchData: '',
                sortMethod: {
                    default: true,
                    time: false,
                    price: false,
                    area: false
                },
                warehouseData: [],
                itemsData: [],
            }
        },
        mounted: function() {
            this.getSelectData();
        },
        methods: {
            /**
             * 获取数据
             **/
            getData: function() {
                let _this = this;
                WarehouseAPI.getData(this.condition).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.currentPage = 1;
                        let start = ( _this.currentPage - 1 ) * _this.pageSize;
                        _this.warehouseData = response.data.data;
                        _this.totalNumber = response.data.data.length;
                        _this.itemsData = response.data.data.slice(start, _this.pageSize);
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取搜索信息
             */
            getSearchData: function() {
                this.getData();
            },
            /**
             * 获取选择数据
             * */
            getSelectData: function() {
                let _this = this;
                WarehouseAPI.getSelectData().then( function(response){
                    if(response.data.errCode === 0) {
                        let condition = {
                            price: [0, response.data.data.maxPrice],
                            length: [0, response.data.data.maxLength],
                            width: [0, response.data.data.maxWidth],
                            height: [0, response.data.data.maxHeight]
                        };
                        _this.$store.commit('setWarehouseCondition', condition);
                        _this.$store.commit('setSelectWarehouseData', response.data.data);
                        _this.condition.searchData = _this.$store.state.home.searchInfo;
                        _this.getData();
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 改变页码
             * */
            changePage: function(page) {
                this.currentPage = page;
                let start = ( this.currentPage - 1 ) * this.pageSize;
                this.itemsData = this.warehouseData.slice(start, (this.pageSize + start));
                document.querySelector('.back-top').click();
            },
            /**
             * 默认排序
             * */
            defaultSort: function() {
                this.hiddenAll();
                this.currentPage = 1;
                this.condition.orderData = 'warehouseId';
                this.condition.method = 'desc';
                this.sortMethod.default = true;
                this.getData();
            },
            /**
             *  时间排序
             * */
            timeSort: function() {
                this.hiddenAll();
                this.currentPage = 1;
                this.condition.orderData = 'created_at';
                this.sortMethod.time = true;
                this.getData();
            },
            /**
             * 价格排序
             * */
            priceSort: function() {
                this.hiddenAll();
                this.currentPage = 1;
                this.sortMethod.price = true;
                if(this.priceSortStatus === 'up') {
                    this.priceSortStatus = 'down';
                    this.condition.method = 'desc';
                } else {
                    this.priceSortStatus = 'up';
                    this.condition.method = 'asc';
                }
                this.condition.orderData = 'price';
                this.getData();
            },
            // /**
            //  * 面积排序
            //  * */
            // areaSort: function() {
            //     this.hiddenAll();
            //     this.currentPage = 1;
            //
            //     // this.sortMethod.weight = true;
            //     // if(this.weightSortStatus === 'up') {
            //     //     this.weightSortStatus = 'down';
            //     //     this.condition.method = 'desc';
            //     // } else {
            //     //     this.weightSortStatus = 'up';
            //     //     this.condition.method = 'asc';
            //     // }
            //     // this.condition.orderData = 'maxWeight';
            //     // this.getData();
            // },
            /**
             * 隐藏全部样式
             * */
            hiddenAll: function() {
                for(let key in this.sortMethod) {
                    this.sortMethod[key] = false;
                }
            },
            /**
             * 返回首页
             */
            goHome: function() {
                this.$router.push('/');
            },
            /**
             * 查看历史订单
             */
            goHistoryOrder: function () {
                this.$store.commit('setOrderType', 'warehouse');
                this.$router.push('/historyOrder');
            }
        },
        computed: {
            condition: function() {
                return this.$store.state.warehouse.condition;
            }
        },
        components: {
            userHeader,
            selectCondition,
            Item,
            userFooter
        }
    }
</script>