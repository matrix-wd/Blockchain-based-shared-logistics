<style lang="less">
    @import '../../../less/index.less';
    @import '../../../less/service.less';
</style>

<template>
    <div id="conveyance">
        <userHeader></userHeader>
        <Row class="first-row">
            <Col span="20" offset="2">
                <img src="../../../img/logo.png" @click="goHome" class="logo-img" alt="logo" />
                <div class="search-box">
                    <input type="text" v-on:keyup.enter="getSearchData" v-model="condition.searchData" class="user-input" placeholder="请输入仓储地址与需求进行查找" />
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
                <selectCondition :conveyanceCondition="showCondition" @getData="getData"></selectCondition>
                <Divider />
            </Col>
        </Row>
        <Row class="select-type-box">
            <Col span="20" offset="2">
                <p class="title-p">
                    共找到<span class="number">{{totalNumber}}</span>个运输资源
                </p>
                <div class="order-type">
                    <ul>
                        <li :class="{ active: sortMethod.default}" @click="defaultSort">默认排序</li>
                        <li :class="{ active: sortMethod.time}" @click="timeSort">最新</li>
                        <li :class="{ active: sortMethod.price}" @click="priceSort">
                            价格
                            <Icon :type="'ios-arrow-round-' + priceSortStatus" />
                        </li>
                        <li :class="{ active: sortMethod.weight}" @click="weightSort">
                            载重
                            <Icon :type="'ios-arrow-round-' + weightSortStatus" />
                        </li>
                    </ul>
                </div>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <Item :items="itemsData" :conveyanceStatus="showCondition"></Item>
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
    import ConveyanceAPI from '../../api/conveyance.js';
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
                weightSortStatus: 'up',
                // searchData: '',
                sortMethod: {
                    default: true,
                    time: false,
                    price: false,
                    weight: false
                },
                conveyanceData: [],
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
                ConveyanceAPI.getData(this.condition).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.currentPage = 1;
                        let start = ( _this.currentPage - 1 ) * _this.pageSize;
                        _this.conveyanceData = response.data.data;
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
                ConveyanceAPI.getSelectData().then( function(response){
                    if(response.data.errCode === 0) {
                        let condition = {
                            price: [0, response.data.data.maxPrice],
                            length: [0, response.data.data.maxLength],
                            width: [0, response.data.data.maxWidth],
                            height: [0, response.data.data.maxHeight],
                            maxWeight: [0, response.data.data.maxWeight]
                        };
                        _this.$store.commit('setConveyanceCondition', condition);
                        _this.$store.commit('setSelectConveyanceData', response.data.data);
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
                this.itemsData = this.conveyanceData.slice(start, (this.pageSize + start));
                document.querySelector('.back-top').click();
            },
            /**
             * 默认排序
             * */
            defaultSort: function() {
                this.hiddenAll();
                this.currentPage = 1;
                this.condition.orderData = 'conveyanceId';
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
            /**
             * 面积排序
             * */
            weightSort: function() {
                this.hiddenAll();
                this.currentPage = 1;
                this.sortMethod.weight = true;
                if(this.weightSortStatus === 'up') {
                    this.weightSortStatus = 'down';
                    this.condition.method = 'desc';
                } else {
                    this.weightSortStatus = 'up';
                    this.condition.method = 'asc';
                }
                this.condition.orderData = 'maxWeight';
                this.getData();
            },
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
                this.$store.commit('setOrderType', 'conveyance');
                this.$router.push('/historyOrder');
            }
        },
        computed: {
            condition: function() {
                return this.$store.state.conveyance.condition;
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