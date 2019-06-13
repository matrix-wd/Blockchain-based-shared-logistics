<style lang="less">
    #user-content-link {
        padding: 50px 0;
        background-color: white;
        text-align: center;
        h5 {
            padding: 20px 0 0 10px;
            font-size: 18px;
        }
        .sub-title {
            font-size: 12px;
            color: #ccc;
        }
        .link-img {
            cursor: pointer;
            width: 80px;
        }
    }
</style>

<template>
    <div id="user-content-link">
        <Row>
            <Col span="6" offset="3">
                <img src="../../../../img/home/warehouse.png" class="link-img" @click="goResource" />
                <h5>资源寻找</h5>
                <span class="sub-title">查看优质资源，满足您的需求</span>
            </Col>
            <Col span="6">
                <img src="../../../../img/home/calculate.png" @click="calculatePrice" class="link-img" />
                <h5>价格估计</h5>
                <span class="sub-title">基于海量数据，帮您合理定价</span>
            </Col>
            <Col span="6">
                <img src="../../../../img/home/order.png" @click="lookOrder" class="link-img" />
                <h5>订单查看</h5>
                <span class="sub-title">查看历史订单，了解市场环境</span>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
            /**
             *  寻找资源
             */
            goResource: function() {
                this.$router.push('/warehouse');
            },
            /**
             * 前往估价页面
             */
            calculatePrice: function () {
                this.$router.push('/calculatePrice');
            },
            /**
             * 前往订单页面
             */
            lookOrder: function () {
                this.$router.push('/historyOrder');
            }
        }
    }
</script>