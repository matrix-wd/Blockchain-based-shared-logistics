<style lang="less">
    @import "../../../less/index.less";
    #admin-contract {

    }
</style>
<template>
    <div id="admin-contract">
        <adminTable :columns="columns" :data="tableData"></adminTable>
    </div>
</template>

<script>

    import adminTable from '../../components/admin/admin-table.vue';
    import Web3 from 'web3';
    import abi from '../../block-chain/abi.js';

    export default {
        data() {
            return {
                web3js: null,
                contract: null,
                myAddress: null,
                contractAddress: '0xd494b2948cf7f790b43e78ab6d77dad5335fd392',
                columns: [
                    {
                        title: '所在块的编号',
                        align: 'center',
                        width: 150,
                        key: 'blockNumber'
                    },
                    {
                        title: '所在块的哈希值',
                        align: 'center',
                        key: 'blockHash'
                    },
                    {
                        title: '交易签名',
                        align: 'center',
                        key: 'signature',
                    },
                    {
                        title: '交易哈希值',
                        align: 'center',
                        key: 'transactionHash'
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
                                        _this.lookContactInfo(params.row);
                                    }
                                }
                            }, '更多信息');
                            return h('div', [lookBtn]);
                        }
                    }
                ],
                tableData: []
            }
        },
        mounted: function() {
            this.getContractData();
        },
        methods: {
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
                this.contract.events.EtherChange({
                    fromBlock: 0
                }, (error, event) => {
                    this.tableData.push({
                        'blockNumber' : event.blockNumber,
                        'blockHash' : event.blockHash,
                        'signature' : event.signature,
                        'transactionHash' : event.transactionHash
                    })
                })
            },
            /**
             * 查看更多信息
             */
            lookContactInfo: function (row) {
                this.web3js.eth.getBlock(row.blockNumber).then( (res) => {
                    let content = '父块哈希：' + res.parentHash +
                        '<br/>矿工地址：' + res.miner +
                        '<br/>该块难度：' + res.difficulty +
                        '<br/>块大小：' + res.size +
                        '<br/>出块的unix时间戳：' + res.timestamp;
                    this.$Modal.info({
                        title: '订单详情',
                        width: 720,
                        content: content
                    })
                });
            }
        },
        components: {
            adminTable
        }
    }
</script>