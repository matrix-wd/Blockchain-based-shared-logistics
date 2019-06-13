ss<style lang="less">
    #four-card {
        background-color: white;
        padding: 20px 0 40px 0;
        .card-box {
            .item-box {
                margin-top: 20px;
                img {
                    cursor: pointer;
                    max-width: 100%;
                    height: 200px;
                }
            }
            .description-box {
                position: absolute;
                width: 100%;
                text-align: center;
                left: 0;
                top: 40%;
                margin: auto;
                h5 {
                    color: white;
                    font-weight: 600;
                    padding-bottom: 10px;
                }
                p {
                    font-size: 16px;
                    color: #f8ab41;
                    output {
                        font-weight: 600;
                    }
                }
            }
        }
    }
</style>

<template>
    <div id="four-card">
        <Row class="card-box">
            <Col span="24">
                <Row :gutter="16">
                    <Col span="6" class="item-box" v-for="item in data">
                        <Card>
                            <div @click="lookInfo(item)">
                                <img :src="item.imagePath.split(';')[0]" class="img-" alt="conveyance" />
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