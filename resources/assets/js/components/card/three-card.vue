<style lang="less">
    #three-card {
        padding: 20px 0 40px 0;
        .card-box {
            .item-box {
                margin-top: 20px;
                text-align: center;
                img {
                    cursor: pointer;
                    max-width: 100%;
                    height: 250px;
                }
                .description-box {
                    text-align: left;
                    padding-top: 20px;
                    h5 {
                        font-weight: 600;
                        padding-bottom: 10px;
                    }
                }
            }
        }
    }
</style>

<template>
    <div id="three-card">
        <Row class="card-box">
            <Col span="24">
                <Row :gutter="16">
                    <Col span="8" class="item-box" v-for="item in data">
                        <Card>
                            <div @click="lookInfo(item)">
                                <img :src="item.imagePath.split(';')[0]" alt="warehouse" />
                                <div class="description-box">
                                    <h5>{{item.province}}{{item.city}}</h5>
                                    <p>{{item.price}}元
                                        <span v-if="type === 'warehouse'">天/平米</span>
                                        <span v-if="type === 'conveyance'">千米/平米</span>
                                    </p>
                                </div>
                            </div>
                        </Card>
                    </Col>
                </Row>
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
             * 查看详细信息
             */
            lookInfo: function (item) {
                localStorage.setItem("resourceId", item.resourceId);
                localStorage.setItem("type", this.type);
                if(this.$route.path === '/resourceInfo') {
                    location.reload();
                } else {
                    this.$router.push('/resourceInfo');
                }
            }  
        },
        props: {
            data: {
                type: Array
            },
            type: {
                type: String
            }
        }
    }
</script>