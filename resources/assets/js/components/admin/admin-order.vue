<style lang="less">
    @import "../../../less/index.less";
    #admin-order {

    }
</style>
<template>
    <div id="admin-order">
        <adminTable :columns="columns" :data="tableData"></adminTable>
    </div>
</template>

<script>

    import adminTable from '../../components/admin/admin-table.vue';
    import conveyanceOrderAPI from '../../api/conveyanceOrder.js';
    import warehouseOrderAPI from '../../api/warehouseOrder.js';
    export default {
        data () {
            return {
                conveyanceColumns: [
                    {
                        title: '资源ID',
                        width: 100,
                        align: 'center',
                        key: 'conveyanceId',
                    },
                    {
                        title: '租户',
                        width: 120,
                        align: 'center',
                        key: 'telephone'
                    },
                    {
                        title: '价格(元)',
                        align: 'center',
                        width: 100,
                        key: 'price'
                    },
                    {
                        title: '商品内容',
                        width: 150,
                        align: 'center',
                        key: 'content'
                    },
                    {
                        title: '租用面积(平米)',
                        width: 120,
                        align: 'center',
                        key: 'area'
                    },
                    {
                        title: '总额(元)',
                        width: 100,
                        align: 'center',
                        key: 'amount'
                    },
                    {
                        title: '状态',
                        align: 'center',
                        key: 'status',
                        render: (h, params) => {
                            let res = '';
                            let color = '';
                            switch (params.row.status) {
                                case '-1':
                                    color = '#ed4014';
                                    res = '资源方拒绝了改单，拒单原因：' + params.row.replyContent; break;
                                case '0':
                                    color = '#2db7f5';
                                    res = '用户已预约，资源方未审核'; break;
                                case '1':
                                    color = '#ff9900';
                                    res = '资源方已接单，用户未付款'; break;
                                case '2':
                                    color = '#2db7f5';
                                    res = '用户已付款，正在服务中'; break;
                                case '3':
                                    color = '#ed4014';
                                    res = '用户申请退款，退款理由：' + params.row.replyContent + ',资源方未审核'; break;
                                case '4':
                                    color = '#19be6b';
                                    res = '资源方同意了退款请求'; break;
                                case '5':
                                    color = '#ed4014';
                                    res = '资源方拒绝了退款请求'; break;
                                default:
                                    color = '#19be6b';
                                    res = '已完成'; break;
                            }
                            return h('span',{style: {color: color}}, res);
                        }
                    },
                    {
                        title: '订单时间',
                        width: 150,
                        align: 'center',
                        key: 'created_at',
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 180,
                        align: 'center',
                        render: (h, params) => {
                            let _this = this;
                            let lookBtn = h('Button', {
                                attrs: {
                                    size: "small",
                                    type: "info"
                                },
                                on: {
                                    click: function () {
                                        _this.lookConveyanceInfo(params.row);
                                    }
                                }
                            }, '更多信息');
                            return h('div', [lookBtn]);
                        }
                    }
                ],
                warehouseColumns: [
                    {
                        title: '资源ID',
                        width: 100,
                        align: 'center',
                        key: 'warehouseId',
                    },
                    {
                        title: '租户',
                        width: 120,
                        align: 'center',
                        key: 'telephone'
                    },
                    {
                        title: '价格(元)',
                        align: 'center',
                        width: 100,
                        key: 'price'
                    },
                    {
                        title: '商品内容',
                        width: 150,
                        align: 'center',
                        key: 'content'
                    },
                    {
                        title: '租用面积(平米)',
                        width: 120,
                        align: 'center',
                        key: 'area'
                    },
                    {
                        title: '总额(元)',
                        width: 100,
                        align: 'center',
                        key: 'amount'
                    },
                    {
                        title: '状态',
                        align: 'center',
                        key: 'status',
                        render: (h, params) => {
                            let res = '';
                            let color = '';
                            switch (params.row.status) {
                                case '-1':
                                    color = '#ed4014';
                                    res = '资源方拒绝了改单，拒单原因：' + params.row.replyContent; break;
                                case '0':
                                    color = '#2db7f5';
                                    res = '用户已预约，资源方未审核'; break;
                                case '1':
                                    color = '#ff9900';
                                    res = '资源方已接单，用户未付款'; break;
                                case '2':
                                    color = '#2db7f5';
                                    res = '用户已付款，正在服务中'; break;
                                case '3':
                                    color = '#ed4014';
                                    res = '用户申请退款，退款理由：' + params.row.replyContent + ',资源方未审核'; break;
                                case '4':
                                    color = '#19be6b';
                                    res = '资源方同意了退款请求'; break;
                                case '5':
                                    color = '#ed4014';
                                    res = '资源方拒绝了退款请求'; break;
                                default:
                                    color = '#19be6b';
                                    res = '已完成'; break;
                            }
                            return h('span',{style: {color: color}}, res);
                        }
                    },
                    {
                        title: '订单时间',
                        width: 150,
                        align: 'center',
                        key: 'created_at',
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 180,
                        align: 'center',
                        render: (h, params) => {
                            let _this = this;
                            let lookBtn = h('Button', {
                                attrs: {
                                    size: "small",
                                    type: "info"
                                },
                                on: {
                                    click: function () {
                                        _this.lookWarehouseInfo(params.row);
                                    }
                                }
                            }, '更多信息');
                            return h('div', [lookBtn]);
                        }
                    }
                ],
                conveyanceData: [],
                warehouseData: []
            }
        },
        props: {
            orderType: {
                type: String,
                default: 'conveyance'
            }
        },
        methods: {
            /**
             * 查看详情
             */
            lookWarehouseInfo: function(row) {
                let score;
                if(row.status !== 6) {
                    score = '未完成，暂无评分'
                } else {
                    score = row.score;
                }
                let content = '租用时间段：' + row.startDate + ' ～ ' + row.endDate +
                    '<br/>租用时间：' + row.rentDays + '天' +
                    '<br/>评分：' + score;
                this.$Modal.info({
                    title: '订单详情',
                    content: content,
                })
            },
            /**
             * 查看详情
             */
            lookConveyanceInfo: function(row) {
                let score;
                if(row.status !== 6) {
                    score = '未完成，暂无评分'
                } else {
                    score = row.score;
                }
                let content = '目的地：' + row.address +
                    '<br/>距离：' + row.distance + '千米' +
                    '<br/>评分：' + score;
                this.$Modal.info({
                    title: '订单详情',
                    content: content,
                });
            },
            /**
             * 获取运输数据
             */
            getConveyanceData: function () {
                let _this = this;
                conveyanceOrderAPI.getOrderDataAdmin().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.conveyanceData = response.data.data;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取仓储数据
             */
            getWarehouseData: function () {
                let _this = this;
                warehouseOrderAPI.getOrderDataAdmin().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.warehouseData = response.data.data;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
        },
        mounted: function() {
            this.getConveyanceData();
        },
        computed: {
            tableData: function () {
                if(this.orderType === 'conveyance') {
                    if(this.conveyanceData.length === 0) {
                        this.getConveyanceData();
                    }
                    return this.conveyanceData;
                } else {
                    if(this.warehouseData.length === 0) {
                        this.getWarehouseData();
                    }
                    return this.warehouseData;
                }
            },
            columns: function () {
                if(this.orderType === 'conveyance') {
                    return this.conveyanceColumns;
                } else {
                    return this.warehouseColumns;
                }
            },
        },
        components: {
            adminTable
        }
    }
</script>