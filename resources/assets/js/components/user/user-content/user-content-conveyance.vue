<style lang="less">
    #user-content-conveyance {
        background-color: white;
        padding: 60px 0 40px 0;
        h1 {
            font-size: 24px;
            font-weight: 200;
            padding-bottom: 10px;
            .title {
                font-weight: 600;
            }
        }
        .sub-title {
            font-size: 14px;
            color: #999;
        }
        .more-conveyance {
            cursor: pointer;
            padding-top: 43px;
            float: right;
            font-size: 14px;
        }
    }
</style>

<template>
    <div id="user-content-conveyance">
        <Row>
            <Col span="10" offset="2">
                <h1><span class="title">运输</span> 为您推荐</h1>
                <span class="sub-title">安全可靠，验货付款</span>
            </Col>
            <Col span="10">
                <span class="more-conveyance" @click="lookMore">更多运输资源</span>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <fourCard :data="result" :type="type"></fourCard>
            </Col>
        </Row>
    </div>
</template>

<script>
    import fourCard from '../../card/four-card.vue';
    import ConveyanceOrderAPI from '../../../api/conveyanceOrder.js';
    export default {
        data() {
            return {
                number: 4,
                type: 'conveyance',
                result: []
            }
        },
        mounted: function() {
            this.getRecommendConveyanceData();
        },
        methods: {
            /**
             * 获取推荐的资源
             */
            getRecommendConveyanceData: function () {
                let _this = this;
                ConveyanceOrderAPI.getRecommendData(this.number).then( function(response){
                    if(response.data.errCode === 0) {
                        _this.result = response.data.data;
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 查看更多
             */
            lookMore: function () {
                this.$router.push('/conveyance');
            }
        },
        components: {
            fourCard
        }
    }
</script>