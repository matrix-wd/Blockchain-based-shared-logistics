<style lang="less">
    #tools {
        .transfer-box {
            margin-top: 60px;
        }
    }
</style>
<template>
    <div id="tools">
        <header-title :title="title" :info="info"></header-title>
        <Row class="transfer-box">
            <Col span="4" offset="4">
                <InputNumber style="width: 100%" size="large" placeholder="请输入人民币数量" :min="0" v-model="rmb"></InputNumber>
            </Col>
            <Col span="2" offset="3">
                <Button style="width: 100%" size="large" @click="RmbToEth">转换</Button>
            </Col>
            <Col span="4" offset="3">
                <InputNumber style="width: 100%" size="large" placeholder="请输入以太币数量" :min="0" v-model="eth"></InputNumber>
            </Col>
        </Row>
        <Row class="transfer-box">
            <Col span="4" offset="4">
                <InputNumber style="width: 100%" size="large" placeholder="请输入以太币数量" :min="0" v-model="eth2"></InputNumber>
            </Col>
            <Col span="2" offset="3">
                <Button style="width: 100%" size="large" @click="EthToRmb">转换</Button>
            </Col>
            <Col span="4" offset="3">
                <InputNumber style="width: 100%" size="large" placeholder="请输入人民币数量" :min="0" v-model="rmb2"></InputNumber>
            </Col>
        </Row>
    </div>
</template>

<script>

    import headerTitle from '../../components/user/header-title.vue';
    import Tools_API from '../../api/tools.js';
    export default {
        data() {
            return {
                title: '价格转换',
                info: '查看最新以太币价格，人民币和以太币之间进行汇率转换',
                ratio: null,
                // dollar: null,
                rmb: null,
                rmb2: null,
                eth: null,
                eth2: null
            }
        },
        methods: {
            /**
             * 人民币和以太币相互转换
             * @constructor
             */
            RmbToEth: function () {
                if(this.rmb === 0 || this.rmb === null) {
                    this.$Message.warning('请输入人民币数量');
                    return false;
                }
                if(this.ratio !== null) {
                    this.eth = this.rmb / this.ratio;
                    return false;
                }
                let _this = this;
                Tools_API.RmbToEth().then( function(response){
                    _this.eth = _this.rmb / response.data.data;
                    _this.ratio = response.data.data;
                }).catch( function(){
                    this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 以太币和人民币相互转换
             */
            EthToRmb: function () {
                if(this.eth2 === 0 || this.eth2 === null) {
                    this.$Message.warning('请输入以太币数量');
                    return false;
                }
                if(this.ratio !== null) {
                    this.rmb2 = this.eth2 * this.ratio;
                    return false;
                }
                let _this = this;
                Tools_API.RmbToEth().then( function(response){
                    _this.rmb2 = _this.eth2 * response.data.data;
                    _this.ratio = response.data.data;
                }).catch( function(){
                    this.$Message.warning('请求出现异常');
                });
            }
        },
        components: {
            headerTitle
        }
    }
</script>