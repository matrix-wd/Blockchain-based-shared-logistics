<style lang="less">
    @import '../../../less/index.less';
    #calculate-price {
        .menu-box {
            margin-bottom: 40px;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            user-select: none;
            .active {
                color: @primary-color;
            }
        }
    }
</style>

<template>
    <div id="calculate-price">
        <headerTitle :title="title" :info="info"></headerTitle>
        <Row class="menu-box">
            <Col offset="8" span="4">
                <span :class="{active: conveyanceStatus}" @click="showConveyance">运输服务估价</span>
            </Col>
            <Col span="4">
                <span :class="{active: warehouseStatus}" @click="showWarehouse">仓储服务估价</span>
            </Col>
        </Row>
        <Row>
            <Col span="12" offset="6">
                <ResourcePrice :warehouseStatus="warehouseStatus" :conveyanceStatus="conveyanceStatus"></ResourcePrice>
            </Col>
        </Row>
    </div>
</template>


<script>
    import headerTitle from '../../components/user/header-title.vue';
    import ResourcePrice from '../../components/user/resource-price.vue';
    export default {
        data() {
            return {
                warehouseStatus: false,
                conveyanceStatus: true,
                title: '估价服务',
                info: '基于骆驼真实的成交数据，让估价服务可以客观准确地预计出该服务的价格'
            }
        },
        methods: {
            /**
             * 显示仓储估计
             */
            showWarehouse: function () {
                this.conveyanceStatus = false;
                this.warehouseStatus = true;
            },
            /**
             * 显示运输估价
             */
            showConveyance: function () {
                this.warehouseStatus = false;
                this.conveyanceStatus = true;
            },
            /**
             * 返回首页
             */
            goHome: function () {
                this.$router.push('/');
            }
        },
        components: {
            ResourcePrice,
            headerTitle
        }
    }
</script>