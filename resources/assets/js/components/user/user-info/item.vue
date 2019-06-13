<style lang="less">
    @import '../../../../less/index.less';
    #item {
        .item {
            height: 320px;
            margin-top: 50px;
            .img-box {
                .item-img {
                    cursor: pointer;
                    max-width: 100%;
                    height: 276px;
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
                        margin-top: 8px;
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
        <Row v-else class="item" v-for="item in items">
            <Col span="8" class="img-box">
                <img @click="lookInfo(item)" :src="item.imagePath.split(';')[0]" class="item-img" alt="warehouse" />
            </Col>
            <Col offset="1" span="15" class="item-info">
                <h4 @click="lookInfo(item)" class="item-title">{{item.title}}</h4>
                <p class="price"><span class="number">{{item.price}}</span>{{unitName}}</p>
                <ul class="list-info">
                    <template v-if="parent === 'order' || parent === 'rent'">
                        <li v-if="warehouseStatus">
                            <span class="key">租用时间</span>
                            {{item.startDate}} ～ {{item.endDate}}
                        </li>
                        <li v-if="conveyanceStatus">
                            <span class="key">距离</span>
                            {{item.distance}}千米
                        </li>
                        <li><span class="key">所属单位</span>{{item.category}}</li>
                        <li><span class="key">下单时间</span>{{item.created_at}}</li>
                        <li><span class="key">仓储物品</span>{{item.content}}</li>
                        <li><span class="key">租用面积</span>{{item.area}}平米</li>
                        <li class="address" v-if="warehouseStatus">
                            <span class="key">资源地址</span>
                            {{item.province}}{{item.city}}{{item.country}}{{item.address}}
                        </li>
                        <li class="address" v-if="conveyanceStatus">
                            <span class="key">目的地</span>
                            {{item.province}}{{item.city}}{{item.country}}{{item.address}}
                        </li>
                        <li><span class="key">总计金额</span>{{item.amount}}元(约{{(item.amount / priceUsd).toFixed(5)}}Ether)</li>
                    </template>
                    <template v-else>
                        <li><span class="key">长*宽*高(米)</span>{{item.length}}*{{item.width}}*{{item.height}}</li>
                        <li><span class="key">总面积</span>{{item.length * item.width}}平米</li>
                        <li v-if="conveyanceStatus"><span class="key">最大载重</span>{{item.maxWeight}}顿</li>
                        <li v-if="warehouseStatus"><span class="key">环境状况</span>{{item.environment}}</li>
                        <li><span class="key">所属单位</span>{{item.category}}</li>
                        <li class="address"><span class="key">地址</span>{{item.province}}{{item.city}}{{item.country}}{{item.address}}</li>
                        <li v-if="parent === 'index'"><span class="key">创建时间</span>{{item.created_at}}</li>
                    </template>

                    <template v-if="parent === 'index'">
                        <li>
                            <Button class="btn" type="primary" @click="updateItem(item)">修改信息</Button>
                            <Button v-if="item.checkedStatus === '1'" class="btn" type="success">审核通过</Button>
                            <Button v-else-if="item.checkedStatus === '-1'" class="btn" type="error">审核未通过</Button>
                            <Button v-else="item.checkedStatus === '0'" class="btn" type="info">未审核</Button>
                            <Button class="btn" v-if="item.usedStatus === '1'" type="primary" @click="updateItemStatus(item)">
                                下架
                            </Button>
                            <Button class="btn" v-if="item.usedStatus === '0'" type="primary" @click="updateItemStatus(item)">
                                上架
                            </Button>
                            <Button class="btn" type="info" @click="lookRentInfo(item)">
                                查看出租情况
                            </Button>
                        </li>
                    </template>
                    <template v-else-if="parent === 'order'">
                        <li v-if="item.status === '-1'">
                            <Button class="btn" type="error" @click="lookRejectReason(item)">预约被拒绝，点击查看原因</Button>
                            <Button class="btn" type="primary" @click="rentItem(item)">再次预约</Button>
                        </li>
                        <li v-else-if="item.status === '0'">
                            <Button class="btn" type="info">预约未被审核</Button>
                        </li>
                        <li v-else-if="item.status === '1'">
                            <Button class="btn" type="primary" @click="payOrder(item)">预约成功，点击付款</Button>
                        </li>
                        <li v-else-if="item.status === '2'">
                            <Button class="btn" type="info">正在服务中</Button>
                            <Button class="btn" type="success" @click="finishOrder(item)">确认收货</Button>
                            <Button class="btn" type="error" @click="refundOrder(item)">申请退款</Button>
                        </li>
                        <li v-else-if="item.status === '3'">
                            <Button class="btn" type="info">正在服务中</Button>
                            <Button class="btn" type="info">退款审核中</Button>
                        </li>
                        <li v-else-if="item.status === '4'">
                            <Button class="btn" type="success">已同意退款申请</Button>
                        </li>
                        <li v-else-if="item.status === '5'">
                            <Button class="btn" type="error">已拒绝退款申请</Button>
                            <Button class="btn" type="success" @click="finishOrder(item)">确认收货</Button>
                            <Button class="btn" type="primary" @click="refundOrder(item)">再次申请</Button>
                        </li>
                        <li v-else-if="item.status === '6'">
                            <Button class="btn" type="success">订单已完成</Button>
                        </li>
                    </template>
                    <template v-else-if="parent === 'rent'">
                        <li v-if="item.status === '-1'">
                            <Button class="btn" type="error">已拒绝</Button>
                        </li>
                        <li v-else-if="item.status === '0'">
                            <Button class="btn" type="success" @click="acceptItem(item)">接单</Button>
                            <Button class="btn" type="error" @click="rejectItem(item)">拒接</Button>
                        </li>
                        <li v-else-if="item.status === '1'">
                            <Button class="btn" type="success">已接单，等待用户付款</Button>
                        </li>
                        <li v-else-if="item.status === '2'">
                            <Button class="btn" type="info">用户已付款</Button>
                        </li>
                        <li v-else-if="item.status === '3'">
                            <Button class="btn" type="error" @click="lookRefundInfo(item)">用户申请退款，点击查看详情</Button>
                        </li>
                        <li v-else-if="item.status === '4'">
                            <Button class="btn" type="success">已同意退款</Button>
                        </li>
                        <li v-else-if="item.status === '5'">
                            <Button class="btn" type="error">已拒绝退款</Button>
                        </li>
                        <li v-else-if="item.status === '6'">
                            <Button class="btn" type="success">订单已完成</Button>
                        </li>
                    </template>

                    <template v-else>
                        <li>
                            <Button class="btn" type="primary" @click="cancelAttentionItem(item)">取消关注</Button>
                            <Button class="btn" type="primary" @click="rentItem(item)">预约</Button>
                        </li>
                    </template>
                </ul>
            </Col>
        </Row>
    </div>
</template>

<script>
    import AttentionAPI from '../../../api/attention.js';
    import WarehouseOrderAPI from '../../../api/warehouseOrder.js';
    import ConveyanceOrderAPI from '../../../api/conveyanceOrder.js';
    import ConveyanceAPI from '../../../api/conveyance.js';
    import WarehouseAPI from '../../../api/warehouse.js';
    import UserAPI from '../../../api/user.js';
    import Web3 from 'web3';
    import abi from '../../../block-chain/abi.js';
    import adminTable from '../../admin/admin-table.vue';

    export default {
        data() {
            return {
                replyContent: '',
                resourcerBlockAddress: '',
                score: null,
                web3js: null,
                contract: null,
                myAddress: null,
                contractAddress: '0xd494b2948cf7f790b43e78ab6d77dad5335fd392',
                conveyanceColumns: [
                    // {
                    //     title: '资源ID',
                    //     width: 100,
                    //     align: 'center',
                    //     key: 'conveyanceId',
                    // },
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
                    // {
                    //     title: '操作',
                    //     key: 'action',
                    //     width: 180,
                    //     align: 'center',
                    //     render: (h, params) => {
                    //         let _this = this;
                    //         let lookBtn = h('Button', {
                    //             attrs: {
                    //                 size: "small",
                    //                 type: "info"
                    //             },
                    //             on: {
                    //                 click: function () {
                    //                     _this.lookConveyanceInfo(params.row);
                    //                 }
                    //             }
                    //         }, '更多信息');
                    //         return h('div', [lookBtn]);
                    //     }
                    // }
                ],
                warehouseColumns: [
                    // {
                    //     title: '资源ID',
                    //     width: 100,
                    //     align: 'center',
                    //     key: 'warehouseId',
                    // },
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
                    // {
                    //     title: '操作',
                    //     key: 'action',
                    //     width: 180,
                    //     align: 'center',
                    //     render: (h, params) => {
                    //         let _this = this;
                    //         let lookBtn = h('Button', {
                    //             attrs: {
                    //                 size: "small",
                    //                 type: "info"
                    //             },
                    //             on: {
                    //                 click: function () {
                    //                     _this.lookWarehouseInfo(params.row);
                    //                 }
                    //             }
                    //         }, '更多信息');
                    //         return h('div', [lookBtn]);
                    //     }
                    // }
                ],
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
                    style: {
                        'zIndex': 1002
                    }
                });
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
                    style: {
                        'zIndex': 1002
                    }
                })
            },
            /**
             * 查看资源出租情况
             */
            lookRentInfo: function(item) {
                if(this.type === 'warehouse') {
                    this.lookWarehouseRentInfo(item);
                } else {
                    this.lookConveyanceRentInfo(item);
                }
            },
            /**
             * 查看运输资源出租情况
             */
            lookConveyanceRentInfo: function(item) {
                let _this = this;
                ConveyanceOrderAPI.getRentInfo(item.conveyanceId).then( function(response){
                    if(response.data.errCode === 0) {
                        let _this_ = _this;
                        _this.$Modal.info({
                            width: 1200,
                            render: h => {
                                return h(adminTable, {
                                    props: {
                                        data: response.data.data,
                                        parent: 'item',
                                        columns: _this_.conveyanceColumns,
                                    }
                                });
                            }
                        });
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 查看仓储资源出租情况
             */
            lookWarehouseRentInfo: function(item) {
                let _this = this;
                WarehouseOrderAPI.getRentInfo(item.warehouseId).then( function(response){
                    if(response.data.errCode === 0) {
                        let _this_ = _this;
                        _this.$Modal.info({
                            width: 1200,
                            render: h => {
                                return h(adminTable, {
                                    props: {
                                        data: response.data.data,
                                        parent: 'item',
                                        columns: _this_.warehouseColumns,
                                    }
                                });
                            }
                        })
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 修改当前状态
             */
            updateItemStatus: function(item) {
                if(this.type === 'warehouse') {
                    this.updateWarehouseUsedstatus(item);
                } else {
                    this.updateConveyanceUsedstatus(item);
                }
            },
            /**
             * 修改运输资源的使用状态
             */
            updateConveyanceUsedstatus: function(item) {
                let _this = this;
                ConveyanceAPI.updateUsedStatus(item.conveyanceId).then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].conveyanceId === item.conveyanceId) {
                                _this.items[i].usedStatus = response.data.data;
                                break;
                            }
                        }
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 修改仓储资源的使用状态
             */
            updateWarehouseUsedstatus: function(item) {
                let _this = this;
                WarehouseAPI.updateUsedStatus(item.warehouseId).then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].warehouseId === item.warehouseId) {
                                _this.items[i].usedStatus = response.data.data;
                                break;
                            }
                        }
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 判断用户的信息是否已经完善
             */
            infoStatus: function () {
                let _this = this;
                UserAPI.getUserInfoStatus(this.userId).then( function(response){
                    if(response.data.data === '0') {
                        _this.$Message.warning('请先完善个人信息');
                        _this.$store.commit('hiddenUserModal');
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 获取区块链地址
             */
            getBlockAddress: function(userId) {
                const _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    UserAPI.getBlockAddress(userId).then( function(response){
                        if(response.data.errCode === 0) {
                            __this.resourcerBlockAddress = response.data.data;
                            resolve();
                        }
                    }).catch( function(){
                        __this.$Message.warning('请求出现异常');
                        reject();
                    });
                });
            },
            /**
             * 查看退款信息
             * @param item
             */
            lookRefundInfo: function (item) {
                this.$Modal.confirm({
                    title: '是否同意退款',
                    content: '申请退款理由: ' + item.replyContent,
                    onOk: () => {
                        this.AgreeRefund(item);
                    },
                    onCancel: () => {
                        if(this.type === 'warehouse') {
                            this.DisagreeWarehouseRefund(item);
                        } else {
                            this.DisagreeConveyanceRefund(item);
                        }
                    }
                });
            },
            /**
             * 同意退款
             * 处理异步
             */
            async AgreeRefund(item) {
                await this.getBlockAddress(this.userId);
                this.startApp();
                if(this.type === 'warehouse') {
                    await this.AgreeWarehouseRefund(item);
                } else {
                    await this.AgreeConveyanceRefund(item);
                }
            },
            /**
             * 同意仓储资源退款
             */
            AgreeWarehouseRefund: function(item) {
                let _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    _this.contract.methods.refundWarehouseOrder(item.orderId)
                        .send({from: _this.myAddress}).on('confirmation', (confirmationNumber, receipt) => {
                        if(confirmationNumber > 0) {
                            let _this_ = __this;
                            WarehouseOrderAPI.agreeRefund(item.orderId).then( function(response){
                                if(response.data.errCode === 0) {
                                    for(let i = 0; i < _this_.items.length; i++) {
                                        if(_this_.items[i].orderId === item.orderId) {
                                            _this_.items[i].status = '4';
                                            break;
                                        }
                                    }
                                    _this_.$Spin.hide();
                                    resolve();
                                } else {
                                    _this_.$Message.warning(response.data.data);
                                }
                            }).catch( function(){
                                _this_.$Spin.hide();
                                reject();
                            });
                        }
                    }).on('error', (error) => {
                        __this.$Message.warning('支付出现错误' + error);
                        __this.$Spin.hide();
                        reject();
                    });
                });
            },
            /**
             * 同意运输资源退款
             */
            AgreeConveyanceRefund: function(item) {
                let _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    _this.contract.methods.refundConveyanceOrder(item.orderId)
                        .send({from: _this.myAddress}).on('confirmation', (confirmationNumber, receipt) => {
                        if(confirmationNumber > 0) {
                            let _this_ = __this;
                            ConveyanceOrderAPI.agreeRefund(item.orderId).then( function(response){
                                if(response.data.errCode === 0) {
                                    for(let i = 0; i < _this_.items.length; i++) {
                                        if(_this_.items[i].orderId === item.orderId) {
                                            _this_.items[i].status = '4';
                                            break;
                                        }
                                    }
                                    _this_.$Spin.hide();
                                    resolve();
                                } else {
                                    _this_.$Message.warning(response.data.data);
                                }
                            }).catch( function(){
                                _this_.$Spin.hide();
                                reject();
                            });
                        }
                    }).on('error', (error) => {
                        __this.$Message.warning('支付出现错误' + error);
                        __this.$Spin.hide();
                        reject();
                    });
                });
            },
            /**
             * 拒绝仓储资源退款
             */
            DisagreeWarehouseRefund: function(item) {
                let _this = this;
                ConveyanceOrderAPI.disagreeRefund(item.orderId).then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '5';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 拒绝运输资源退款
             */
            DisagreeConveyanceRefund: function(item) {
                let _this = this;
                ConveyanceOrderAPI.disagreeRefund(item.orderId).then( function(response){
                    if(response.data.errCode === 0) {
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '5';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 申请退款
             */
            refundOrder: function(item) {
                this.$Modal.confirm({
                    title: '请填写信息',
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.replyContent,
                                autofocus: true,
                                type: 'textarea',
                                placeholder: '请输入申请退款原因'
                            },
                            on: {
                                input: (val) => {
                                    this.replyContent = val;
                                }
                            }
                        })
                    },
                    onOk: () => {
                        if(this.replyContent === '') {
                            this.$Message.warning('申请退款原因不能为空');
                            return false;
                        } else {
                            if(this.type === 'warehouse') {
                                this.refundWarehouseItem(item);
                            } else {
                                this.refundConveyanceItem(item);
                            }
                        }
                    },
                });
            },
            /**
             * 仓储资源退款
             */
            refundWarehouseItem: function(item) {
                let _this = this;
                WarehouseOrderAPI.refundItem(item.orderId, this.replyContent).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('申请成功，请等待审核');
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '3';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 运输资源退款
             */
            refundConveyanceItem: function(item) {
                let _this = this;
                ConveyanceOrderAPI.refundItem(item.orderId, this.replyContent).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.success('申请成功，请等待审核');
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '3';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 订单完成
             */
            async finishOrder(item) {
                await this.getBlockAddress(item.userId);
                this.startApp();
                this.$Modal.confirm({
                    title: '请对本次服务评分',
                    render: (h) => {
                        return h('Rate', {
                            props: {
                                value: this.score
                            },
                            on: {
                                input: (val) => {
                                    this.score = val;
                                }
                            }
                        })
                    },
                    onOk: () => {
                        if(this.score === null) {
                            this.$Message.warning('请评分');
                        } else {
                            this.reviewOrder(item);
                        }
                    },
                });
            },
            /**
             *  评价订单，分离出来主要是为了异步
             */
            async reviewOrder(item) {
                if(this.type ==='warehouse') {
                    this.$Spin.show();
                    await this.finishWarehouseOrder(item);
                } else if(this.type === 'conveyance') {
                    this.$Spin.show();
                    await this.finishConveyanceOrder(item);
                }
            },

            /**
             * 结束仓储订单
             */
            finishWarehouseOrder: function(item) {
                let _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    _this.contract.methods.reviewWarehouseOrder(item.orderId)
                        .send({from: _this.myAddress}).on('confirmation', (confirmationNumber, receipt) => {
                        if(confirmationNumber > 0) {
                            let _this_ = __this;
                            WarehouseOrderAPI.finishItem(item.orderId, __this.score).then( function(response){
                                if(response.data.errCode === 0) {
                                    for(let i = 0; i < _this_.items.length; i++) {
                                        if(_this_.items[i].orderId === item.orderId) {
                                            _this_.items[i].status = '6';
                                            break;
                                        }
                                    }
                                    _this_.$Spin.hide();
                                    resolve();
                                } else {
                                    _this_.$Message.warning(response.data.data);
                                }
                            }).catch( function(){
                                _this_.$Spin.hide();
                                reject();
                            });
                        }
                    }).on('error', (error) => {
                        __this.$Message.warning('支付出现错误' + error);
                        __this.$Spin.hide();
                        reject();
                    });
                });
            },
            /**
             * 结束运输订单
             */
            finishConveyanceOrder: function(item) {
                let _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    _this.contract.methods.reviewConveyanceOrder(item.orderId)
                        .send({from: _this.myAddress}).on('confirmation', (confirmationNumber, receipt) => {
                        if(confirmationNumber > 0) {
                            let _this_ = __this;
                            ConveyanceOrderAPI.finishItem(item.orderId, __this.score).then( function(response){
                                if(response.data.errCode === 0) {
                                    for(let i = 0; i < _this_.items.length; i++) {
                                        if(_this_.items[i].orderId === item.orderId) {
                                            _this_.items[i].status = '6';
                                            break;
                                        }
                                    }
                                    _this_.$Spin.hide();
                                    resolve();
                                } else {
                                    _this_.$Message.warning(response.data.data);
                                }
                            }).catch( function(){
                                _this_.$Spin.hide();
                                reject();
                            });
                        }
                    }).on('error', (error) => {
                        __this.$Message.warning('支付出现错误' + error);
                        __this.$Spin.hide();
                        reject();
                    });
                });
            },
            /**
             * 支付订单
             */
            async payOrder(item) {
                await this.getBlockAddress(item.userId);
                this.startApp();
                if(this.type ==='warehouse') {
                    this.$Spin.show();
                    await this.payWarehouseOrder(item);
                } else if(this.type === 'conveyance') {
                    this.$Spin.show();
                    await this.payConveyanceOrder(item);
                }
            },
            /**
             * 仓储订单支付
             */
            payWarehouseOrder(item) {
                let _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    let value = (item.amount / _this.priceUsd).toFixed(16);
                    value = web3.toWei(value, 'ether');
                    _this.contract.methods.addWarehouse(item.orderId, _this.resourcerBlockAddress, item.warehouseId, value)
                        .send({from: _this.myAddress, value: value}).on('confirmation', (confirmationNumber, receipt) => {
                        if(confirmationNumber > 0) {
                            let _this_ = __this;
                            WarehouseOrderAPI.payItem(item.orderId).then( function(response){
                                if(response.data.errCode === 0) {
                                    for(let i = 0; i < _this_.items.length; i++) {
                                        if(_this_.items[i].orderId === item.orderId) {
                                            _this_.items[i].status = '2';
                                            break;
                                        }
                                    }
                                    _this_.$Spin.hide();
                                    resolve();
                                } else {
                                    _this_.$Message.warning(response.data.data);
                                }
                            }).catch( function(){
                                _this_.$Spin.hide();
                            });
                        }
                    }).on('error', (error) => {
                        __this.$Message.warning('支付出现错误' + error);
                        __this.$Spin.hide();
                        reject();
                    });
                });
            },
            /**
             * 运输订单支付
             */
            payConveyanceOrder: function(item) {
                let _this = this;
                return new Promise(function (resolve, reject) {
                    let __this = _this;
                    let value = (item.amount / _this.priceUsd).toFixed(16);
                    value = web3.toWei(value, 'ether');
                    _this.contract.methods.addConveyance(item.orderId, _this.resourcerBlockAddress, item.conveyanceId, value)
                        .send({from: _this.myAddress, value: value}).on('confirmation', (confirmationNumber, receipt) => {
                        if(confirmationNumber > 0) {
                            let _this_ = __this;
                            ConveyanceOrderAPI.payItem(item.orderId).then( function(response){
                                if(response.data.errCode === 0) {
                                    for(let i = 0; i < _this_.items.length; i++) {
                                        if(_this_.items[i].orderId === item.orderId) {
                                            _this_.items[i].status = '2';
                                            break;
                                        }
                                    }
                                    _this_.$Spin.hide();
                                    resolve();
                                } else {
                                    _this_.$Message.warning(response.data.data);
                                }
                            }).catch( function(){
                                _this_.$Spin.hide();
                            });
                        }
                    }).on('error', (error) => {
                        __this.$Message.warning('支付出现错误' + error);
                        __this.$Spin.hide();
                        reject();
                    });
                });
            },
            /**
             * 使用区块链之前的准备
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
             * 接单
             */
            acceptItem: function(item) {
                if(this.type ==='warehouse') {
                    this.acceptWarehouseItem(item);
                } else if(this.type === 'conveyance') {
                    this.acceptConveyanceItem(item);
                }
            },
            /**
             * 拒单
             */
            rejectItem: function(item) {
                this.$Modal.confirm({
                    title: '请填写信息',
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.replyContent,
                                autofocus: true,
                                type: 'textarea',
                                placeholder: '请输入拒绝原因'
                            },
                            on: {
                                input: (val) => {
                                    this.replyContent = val;
                                }
                            }
                        })
                    },
                    onOk: () => {
                        if(this.replyContent === '') {
                            this.$Message.warning('拒绝原因不能为空');
                            return false;
                        } else {
                            if(this.type === 'warehouse') {
                                this.rejectWarehouseItem(item);
                            } else {
                                this.rejectConveyanceItem(item);
                            }
                        }
                    },
                });
            },
            /**
             * 接仓储资源订单
             */
            acceptWarehouseItem: function(item) {
                let _this = this;
                WarehouseOrderAPI.acceptItem(item.orderId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.warning('接单成功');
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '1';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 接运输资源订单
             */
            acceptConveyanceItem: function(item) {
                let _this = this;
                ConveyanceOrderAPI.acceptItem(item.orderId).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.warning('接单成功');
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '1';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 拒绝仓储资源订单
             */
            rejectWarehouseItem: function(item) {
                let _this = this;
                WarehouseOrderAPI.rejectItem(item.orderId, this.replyContent).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.warning('拒单成功');
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '-1';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 拒绝运输资源订单
             */
            rejectConveyanceItem: function(item) {
                let _this = this;
                ConveyanceOrderAPI.rejectItem(item.orderId, this.replyContent).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$Message.warning('拒单成功');
                        for(let i = 0; i < _this.items.length; i++) {
                            if(_this.items[i].orderId === item.orderId) {
                                _this.items[i].status = '-1';
                                break;
                            }
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
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
                this.$store.commit('showUserModal');
                this.$store.commit('setType', this.type);
                this.$store.commit('setItem', item);
            },
            /**
             * 取消关注
             * @param item
             */
            cancelAttentionItem: function (item) {
                let _this = this;
                let id = null;
                if(this.warehouseStatus) {
                    id = item.warehouseId;
                } else {
                    id = item.conveyanceId;
                }
                AttentionAPI.cancelAttention(this.userId, id, this.type).then( function(response){
                    if(response.data.errCode === 0) {
                        if(_this.warehouseStatus) {
                            _this.$store.commit('cancelAttentionWarehouse', item);
                        } else {
                            _this.$store.commit('cancelAttentionConveyance', item);
                        }
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 修改信息
             */
            updateItem: function(item) {
                this.$store.commit('setUpdateItem', item);
                if(this.warehouseStatus) {
                    this.$router.push('/createWarehouse');
                } else {
                    this.$router.push('/createConveyance');
                }
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
            },
            /**
             * 查看拒绝原因
             * @param item
             */
            lookRejectReason: function (item) {
                this.$Modal.error({
                    title: "拒绝原因",
                    content: item.replyContent
                });
            },
        },
        props: {
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
            },
            items: {
                type: Array
            },
            parent: {
                type: String
            }
        },
        components: {
            adminTable
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
                }
                return 'conveyance';
            },
            priceUsd: function () {
                return this.$store.state.home.priceUsd;
            }
        }
    }
</script>