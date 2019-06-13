<style lang="less">
    #user-content-warehouse {
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
        .more-warehouse {
            cursor: pointer;
            padding-top: 43px;
            float: right;
            font-size: 14px;
        }
    }
</style>

<template>
    <div id="user-content-warehouse">
        <Row>
            <Col span="10" offset="2">
                <h1><span class="title">仓储</span> 为您推荐</h1>
                <span class="sub-title">优质仓储，放心存储</span>
            </Col>
            <Col span="10">
                <span @click="lookMore" class="more-warehouse">更多仓储资源</span>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <threeCard :type="type" :data="result"></threeCard>
            </Col>
        </Row>
    </div>
</template>

<script>

    import WarehouseOrderAPI from '../../../api/warehouseOrder.js';
    import threeCard from '../../card/three-card.vue';
    export default {
        data() {
            return {
                result: [],
                type: 'warehouse'
            }
        },
        mounted: function() {
            this.getRecommendData();
        },
        methods: {
            /**
             * 获取推荐数据
             */
            getRecommendData() {
                let _this = this;
                WarehouseOrderAPI.getRecommendData(3).then( function(response){
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
                this.$router.push('/warehouse');
            }
        },
        components: {
            threeCard
        }
    }
</script>