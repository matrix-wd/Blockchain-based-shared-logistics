<style lang="less">
    @import "../../../less/index.less";
    #admin-resource {

    }
</style>
<template>
    <div id="admin-resource">
        <adminTable :parent="parent" :columns="columns" :data="tableData"></adminTable>
    </div>
</template>

<script>

    import adminTable from '../../components/admin/admin-table.vue';
    import conveyanceAPI from '../../api/conveyance.js';
    import warehouseAPI from '../../api/warehouse.js';
    export default {
        data () {
            return {
                parent: 'resource',
                conveyanceColumns: [
                    {
                        title: '资源ID',
                        key: 'conveyanceId',
                        width: 100,
                        align: 'center',
                    },
                    {
                        title: '标题',
                        width: 250,
                        align: 'center',
                        key: 'title'
                    },
                    {
                        title: '地址',
                        align: 'center',
                        key: 'address'
                    },
                    {
                        title: '状态',
                        width: 100,
                        align: 'center',
                        key: 'checkedStatus',
                        render:(h, params) => {
                            if(params.row.checkedStatus === '0') {
                                return h('span', '未审核');
                            } else if(params.row.checkedStatus === '-1'){
                                return h('span', {style: {color: 'red'}}, '未通过');
                            } else {
                                return h('span', {style: {color: 'green'}}, '通过');
                            }
                        }
                    },
                    {
                        title: '类型',
                        width: 70,
                        align: 'center',
                        key: 'category'
                    },
                    {
                        title: '价格',
                        width: 70,
                        align: 'center',
                        key: 'price'
                    },
                    {
                        title: '发布时间',
                        width: 150,
                        align: 'center',
                        key: 'created_at'
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 180,
                        align: 'center',
                        render:(h, params)=>{
                            let _this = this;
                            let lookBtn = h('Button', {
                                attrs: {
                                    size:"small",
                                    type:"info"
                                },
                                on: {
                                    click: function() {
                                        _this.lookInfo(params.row);
                                    }
                                }
                            }, '查看');
                            let passBtn = h('Button', {
                                    attrs: {
                                        size:"small",
                                        type:"success"
                                    },
                                    style: {
                                        marginLeft: '5px'
                                    },
                                    on: {
                                        click: function() {
                                            _this.passResource(params.row, params.index);
                                        }
                                    }
                                }, '通过');
                            let rejectBtn = h('Button', {
                                attrs: {
                                    size:"small",
                                    type: "error"
                                },
                                style: {
                                    marginLeft: '5px',
                                },
                                on: {
                                    click: function() {
                                        _this.rejectResource(params.row, params.index);
                                    }
                                }
                            }, '驳回');
                            return h('div', [lookBtn,passBtn,rejectBtn]);
                        }
                    }
                ],
                warehouseColumns: [
                    {
                        title: '资源ID',
                        key: 'warehouseId',
                        width: 100,
                        align: 'center',
                    },
                    {
                        title: '标题',
                        width: 250,
                        align: 'center',
                        key: 'title'
                    },
                    {
                        title: '地址',
                        align: 'center',
                        key: 'address'
                    },
                    {
                        title: '状态',
                        width: 100,
                        align: 'center',
                        key: 'checkedStatus',
                        render:(h, params) => {
                            if(params.row.checkedStatus === '0') {
                                return h('span', '未审核');
                            } else if(params.row.checkedStatus === '-1'){
                                return h('span', {style: {color: 'red'}}, '未通过');
                            } else {
                                return h('span', {style: {color: 'green'}}, '通过');
                            }
                        }
                    },
                    {
                        title: '类型',
                        width: 70,
                        align: 'center',
                        key: 'category'
                    },
                    {
                        title: '价格',
                        width: 70,
                        align: 'center',
                        key: 'price'
                    },
                    {
                        title: '发布时间',
                        width: 150,
                        align: 'center',
                        key: 'created_at'
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
                                        _this.lookInfo(params.row);
                                    }
                                }
                            }, '查看');
                            let passBtn = h('Button', {
                                attrs: {
                                    size: "small",
                                    type: "success"
                                },
                                style: {
                                    marginLeft: '5px'
                                },
                                on: {
                                    click: function () {
                                        _this.passResource(params.row, params.index);
                                    }
                                }
                            }, '通过');
                            let rejectBtn = h('Button', {
                                attrs: {
                                    size: "small",
                                    type: "error"
                                },
                                style: {
                                    marginLeft: '5px',
                                },
                                on: {
                                    click: function () {
                                        _this.rejectResource(params.row, params.index);
                                    }
                                }
                            }, '驳回');
                            return h('div', [lookBtn, passBtn, rejectBtn]);
                        }
                    }
                ],
                conveyanceData: [],
                warehouseData: []
            }
        },
        props: {
            resourceType: {
                type: String,
                default: 'conveyance'
            }
        },
        methods: {
            /**
             *  审核通过
             */
            passResource: function(row, index) {
                if(this.resourceType === 'conveyance') {
                    this.passConveyance(row, index);
                } else {
                    this.passWarehouse(row, index);
                }
            },
            /**
             * 审核拒绝
             */
            rejectResource: function(row, index) {
                if(this.resourceType === 'conveyance') {
                    this.rejectConveyance(row, index);
                } else {
                    this.rejectWarehouse(row, index);
                }
            },
            /**
             * 运输资源审核通过
             */
            passConveyance: function(row, index) {
                let _this = this;
                conveyanceAPI.passConveyance(row.conveyanceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.conveyanceData[_this.startNumber + index].checkedStatus = '1';
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 运输资源审核不通过
             */
            rejectConveyance: function(row, index) {
                let _this = this;
                conveyanceAPI.rejectConveyance(row.conveyanceId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.conveyanceData[_this.startNumber + index].checkedStatus = '-1';
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 仓储资源审核通过
             */
            passWarehouse: function(row, index) {
                let _this = this;
                warehouseAPI.passWarehouse(row.warehouseId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.warehouseData[_this.startNumber + index].checkedStatus = '1';
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 仓储资源审核不通过
             */
            rejectWarehouse: function(row, index) {
                let _this = this;
                warehouseAPI.rejectWarehouse(row.warehouseId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.warehouseData[_this.startNumber + index].checkedStatus = '-1';
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             *  查看信息
             */
            lookInfo: function(row) {
                if(this.resourceType === 'conveyance') {
                    localStorage.setItem("resourceId", row.conveyanceId);
                } else if(this.resourceType === 'warehouse') {
                    localStorage.setItem("resourceId", row.warehouseId);
                }
                localStorage.setItem("type", this.resourceType);
                this.$router.push('/resourceInfo');
            },
            /**
             * 获取运输数据
             */
            getConveyanceData: function () {
                let _this = this;
                conveyanceAPI.getConveyanceDataAdmin().then( function(response){
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
                warehouseAPI.getWarehouseDataAdmin().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.warehouseData = response.data.data;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            }
        },
        mounted: function() {
            this.getConveyanceData();
        },
        computed: {
            /**
             * 表格数据
             */
            tableData: function () {
                if(this.resourceType === 'conveyance') {
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
            /**
             * 表头
             */
            columns: function () {
                if(this.resourceType === 'conveyance') {
                    return this.conveyanceColumns;
                } else {
                    return this.warehouseColumns;
                }
            },
            /**
             * 当前页码
             * @returns {*}
             */
            currentPage: function () {
                return this.$store.state.admin.currentPage;
            },
            /**
             * 每页数量
             * @returns {default.computed.pageSize|(function())|number|default.watch.pageSize|exports.default.props.pageSize|{type, default}|*}
             */
            pageSize: function() {
                return this.$store.state.admin.pageSize;
            },
            /**
             * 开始
             * @returns {number}
             */
            startNumber: function () {
                return (this.currentPage - 1) * this.pageSize;
            }
        },
        components: {
            adminTable
        }
    }
</script>