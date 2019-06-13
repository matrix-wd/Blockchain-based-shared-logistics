<style lang="less">
    @import "../../../less/index.less";
    #admin-dashboard {
        .row-box {
            margin-top: 30px;
        }
        .row-box {
            margin-top: 22px;
            .draw-box {
                width: 360px;
                height: 240px;
                margin-left: 30px;
                margin-top: 16px;
                float: left;
            }
        }
    }
</style>
<template>
    <div id="admin-dashboard">
        <Row class="row-box">
            <div class="user draw-box">
                <ve-line :data="userData" width="360px" height="280px" :settings="userSettings"></ve-line>
            </div>
            <div class="resource draw-box">
                <ve-histogram :data="conveyanceData" height="280px"></ve-histogram>
            </div>
            <div class="resource draw-box">
                <ve-histogram :data="warehouseData" height="280px"></ve-histogram>
            </div>
            <div class="order draw-box">
                <ve-bar :data="conveyanceOrderData" :settings="orderSettings" height="280px"></ve-bar>
            </div>
            <div class="order draw-box">
                <ve-bar :data="warehouseOrderData" :settings="orderSettings" height="280px"></ve-bar>
            </div>
            <div class="user draw-box">
                <ve-line :data="contractData" :settings="contractSettings" height="280px"></ve-line>
            </div>
        </Row>
    </div>
</template>

<script>

    import AdminAPI from '../../api/admin.js';
    import Web3 from 'web3';
    import abi from '../../block-chain/abi.js';
    export default {
        data() {
            return {
                web3js: null,
                contract: null,
                myAddress: null,
                contractAddress: '0xd494b2948cf7f790b43e78ab6d77dad5335fd392',
                userSettings: {
                    metrics: ['访问用户'],
                    dimension: ['日期']
                },
                orderSettings: {
                    xAxisType: ['KMB', 'KMB'],
                    xAxisName: ['订单数量'],
                    axisSite: {
                        top: []
                    }
                },
                contractSettings: {
                    stack: { '用户': ['访问用户', '下单用户'] },
                    area: true
                },
                conveyanceSettings: {
                    roseType: 'radius'
                },
                /**
                 * 用户数据
                 */
                userData: {
                    columns: ['日期', '访问用户'],
                    rows: [

                    ]
                },
                /**
                 * 资源数据
                 */
                conveyanceData: {
                    columns: ['日期', '运输资源'],
                    rows: [

                    ]
                },
                warehouseData: {
                    columns: ['日期', '仓储资源'],
                    rows: [

                    ]
                },
                conveyanceOrderData: {
                    columns: ['日期', '运输订单'],
                    rows: [

                    ]
                },
                warehouseOrderData: {
                    columns: ['日期', '仓储订单'],
                    rows: [

                    ]
                },
                contractData:{
                    columns: ['日期', '调用次数'],
                    rows: [
                        // { '日期': '1/1', '调用次数': 1393},
                        // { '日期': '1/2', '调用次数': 3530},
                        // { '日期': '1/3', '调用次数': 2923},
                        // { '日期': '1/4', '调用次数': 1723},
                        // { '日期': '1/5', '调用次数': 3792},
                        // { '日期': '1/6', '调用次数': 4593}
                    ]
                }
            }
        },
        mounted: function() {
            this.getUserDashboard();
            this.getWarehouseOrderDashboard();
            this.getConveyanceOrderDashboard();
            this.getConveyanceDashboard();
            this.getWarehouseDashboard();
            this.getContractData();
        },
        methods: {
            /**
             * 获取用户的仪表盘数据
             */
            getUserDashboard: function() {
                let _this = this;
                AdminAPI.getUserDashboard().then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < response.data.loginData.length; i++) {
                            let item = {
                                '日期': response.data.loginData[i]['left(lastLoginTime, 7)'],
                                '访问用户': response.data.loginData[i].number
                            };
                            _this.userData.rows.push(item);
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取订单的仪表盘数据
             */
            getWarehouseOrderDashboard: function () {
                let _this = this;
                AdminAPI.getWarehouseOrderDashboard().then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < response.data.data.length; i++) {
                            let item = {
                                '日期': response.data.data[i].time,
                                '仓储订单': response.data.data[i].number
                            };
                            _this.warehouseOrderData.rows.push(item);
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取订单的仪表盘数据
             */
            getConveyanceOrderDashboard: function () {
                let _this = this;
                AdminAPI.getConveyanceOrderDashboard().then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < response.data.data.length; i++) {
                            let item = {
                                '日期': response.data.data[i].time,
                                '运输订单': response.data.data[i].number
                            };
                            _this.conveyanceOrderData.rows.push(item);
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取运输资源的数据
             */
            getConveyanceDashboard: function () {
                let _this = this;
                AdminAPI.getConveyanceDashboard().then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < response.data.data.length; i++) {
                            let item = {
                                '日期': response.data.data[i].time,
                                '运输资源': response.data.data[i].number
                            };
                            _this.conveyanceData.rows.push(item);
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取仓储资源的数据
             */
            getWarehouseDashboard: function () {
                let _this = this;
                AdminAPI.getWarehouseDashboard().then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < response.data.data.length; i++) {
                            let item = {
                                '日期': response.data.data[i].time,
                                '仓储资源': response.data.data[i].number
                            };
                            _this.warehouseData.rows.push(item);
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 智能合约开始
             */
            startApp: function() {
                if (typeof web3 !== 'undefined') {
                    if(this.web3js === null) {
                        this.web3js = new Web3(web3.currentProvider);
                    }
                    if(this.contract === null) {
                        this.contract = this.web3js.eth.Contract(abi, this.contractAddress);
                    }
                    if(this.myAddress === null) {
                        this.myAddress = web3.eth.accounts[0];
                    }
                } else {
                    this.$Notice.info({
                        title: '提示',
                        desc: error
                    });
                }
            },
            /**
             * 获取合约数据
             */
            getContractData: function () {
                this.startApp();
                let _this = this;
                this.contract.events.EtherChange({
                    fromBlock: 0
                }, (error, event) => {
                    _this.lookContactInfo(event.blockNumber);

                })
            },
            /**
             * 查看更多信息
             */
            lookContactInfo: function (blockNumber) {
                let _this = this;
                this.web3js.eth.getBlock(blockNumber).then( (res) => {
                    let time = new Date(res.timestamp * 1000);
                    let _time = time.getFullYear() + '-' + (time.getMonth() + 1) + '-' + (time.getDate());
                    let flag = true;
                    for(let i = 0; i < _this.contractData.rows.length; i++) {
                        if(_this.contractData.rows[i]['日期'] === _time) {
                            _this.contractData.rows[i]['调用次数'] += 1;
                            flag = false;
                        }
                    }
                    if(flag) {
                        let item = {
                            '日期': _time,
                            '调用次数': 1
                        };
                        _this.contractData.rows.push(item);
                    }
                });
            }
        },
        computed: {

        },
        components: {

        }
    }
</script>