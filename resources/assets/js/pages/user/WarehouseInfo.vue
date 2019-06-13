<style lang="less">
    @import '../../../less/index.less';
    #warehouse-info {
        .title-box {
            background-color: #eee;
            h4 {
                font-weight: 600;
                color: black;
                padding: 40px 0 20px 0;
            }
            .description {
                padding-bottom: 40px;
                font-size: 16px;
            }
        }
        .info-box {
            margin-top: 50px;
            .demo-carousel {
                height: 350px;
                img {
                    height: 100%;
                }
            }
            .basic-info {
                .price {
                    font-size: 18px;
                    span {
                        font-size: 28px;
                        color: @primary-color;
                        font-weight: 600;
                    }
                }
                padding-left: 40px;
                .area-ul {
                    list-style: none;
                    font-size: 14px;
                    li {
                        margin-bottom: 14px;
                        .surplus-area {
                            font-weight: 600;
                            color: @primary-color;
                        }
                    }
                    .key {
                        display: inline-block;
                        color: #888;
                        width: 90px;
                    }
                }
            }
        }
        .recommend-box {
            h4 {
                font-weight: 600;
                color: black;
            }
        }
    }
</style>

<template>
    <div id="warehouse-info">
        <userHeader></userHeader>
        <Row class="title-box">
            <Col span="20" offset="2">
                <h4>宽敞明亮安全仓储宽敞明亮安全仓储</h4>
                <p class="description">周围交通便利，出行方便，随时可以存取货物，易燃易爆物品请勿储存;周围交通便利，出行方便，随时可以存取货物，易燃易爆物品请勿储存</p>
            </Col>
        </Row>
        <Row class="info-box">
            <Col span="10" offset="2">
                <Carousel v-model="value" autoplay loop>
                    <CarouselItem>
                        <div class="demo-carousel">
                            <img src="../../../img/warehouse/two.png" alt="warehouse" />
                        </div>
                    </CarouselItem>
                    <CarouselItem>
                        <div class="demo-carousel">
                            <img src="../../../img/warehouse/two.png" alt="warehouse" />
                        </div>
                    </CarouselItem>
                    <CarouselItem>
                        <div class="demo-carousel">
                            <img src="../../../img/warehouse/two.png" alt="warehouse" />
                        </div>
                    </CarouselItem>
                    <CarouselItem>
                        <div class="demo-carousel">
                            <img src="../../../img/warehouse/two.png" alt="warehouse" />
                        </div>
                    </CarouselItem>
                </Carousel>
            </Col>
            <Col span="10" class="basic-info">
                <p class="price">均价：<span>32</span>/平米/天</p>
                <Divider />
                <ul class="area-ul">
                    <li><span class="key">长*宽*高(米)</span>20*10*6</li>
                    <li><span class="key">总面积</span>269平米</li>
                    <li><span class="key">已使用面积</span>100平米</li>
                    <li><span class="key">剩余面积</span><output class="surplus-area">169</output>平米</li>
                    <li><span class="key">所属单位</span>个人</li>
                    <li><span class="key">联系电话</span>15739081232</li>
                    <li><span class="key">地址</span>浙江省杭州市西湖区文一西路</li>
                </ul>
            </Col>
        </Row>
        <orderInfo></orderInfo>
        <Row class="recommend-box">
            <Col span="20" offset="2">
                <h4>为您推荐优质仓储</h4>
                <fourCard :data="result"></fourCard>
            </Col>
        </Row>
        <userFooter></userFooter>
    </div>
</template>


<script>
    import userHeader from '../../components/user/user-header.vue';
    import orderInfo from '../../components/user/order-info.vue';
    import fourCard from '../../components/card/four-card.vue';
    import userFooter from '../../components/user/user-footer.vue';
    export default {
        data() {
            return {
                result: 8,
                moreStatus: false,
                value: 0,
            }
        },
        methods: {

        },
        components: {
            userHeader,
            orderInfo,
            fourCard,
            userFooter
        }
    }
</script>