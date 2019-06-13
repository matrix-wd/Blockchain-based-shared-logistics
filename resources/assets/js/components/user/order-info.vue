<style lang="less">
    #order-info {
        h4 {
            padding: 50px 0 30px 0;
            color: black;
            font-weight: 600;
        }
        .record-title-box {
            padding-bottom: 20px;
            border-bottom:  1px solid #eee;
            font-size: 16px;
            color: black;
            font-weight: 600;
            list-style: none;
        }
        .record-box {
            line-height: 60px;
            border-bottom:  1px solid #eee;
            height: 60px;
            font-size: 14px;
            .rate-box {
                line-height: 55px;
            }
        }
        .page-box {
            padding: 14px 0 30px 0;
            font-size: 14px;
            text-align: right;
        }
        .blank-content {
            text-align: center;
            font-size: 14px;
            padding: 20px 0;
        }
    }
</style>

<template>
    <div id="order-info">
        <Row>
            <Col span="20" offset="2">
                <h4>历史成交记录</h4>
                <Row class="record-title-box">
                    <Col span="6">
                        成交时间
                    </Col>
                    <Col span="6">
                        用户
                    </Col>
                    <Col span="6">
                        租用面积
                    </Col>
                    <Col span="6">
                        评分
                    </Col>
                </Row>
                <template v-if="blank" v-for="item in currentData">
                    <Row class="record-box">
                        <Col span="6">
                            {{item.pivot.created_at}}
                        </Col>
                        <Col span="6">
                            {{item.telephone.slice(0, 3) + '***' + item.telephone.slice(7, 11)}}
                        </Col>
                        <Col span="6">
                            {{item.pivot.area}}立方米
                        </Col>
                        <Col span="6" class="rate-box">
                            <Rate disabled :value="(item.pivot.score - '0')" />
                        </Col>
                    </Row>
                </template>
                <Row v-if="blank">
                    <Col span="24" class="page-box">
                        <Page :current="currentPage" @on-change="changePage" :page-size="pageSize" :total="totalNumber" size="small" show-total />
                    </Col>
                </Row>
                <Row v-if="!blank">
                    <Row class="blank-content">
                        暂时没有数据
                    </Row>
                </Row>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                pageSize: 5,
                currentPage: 1
            }
        },
        props: {
            items: {
                type: Array
            }
        },
        methods: {
            /**
             * 改变页码
             * @param page
             */
            changePage: function (page) {
                this.currentPage = page;
            }  
        },
        computed: {
            /**
             * 总页码
             * @returns {*}
             */
            totalNumber: function () {
                return this.items.length;
            },
            /**
             * 当前渲染数据
             * @returns {*}
             */
            currentData: function() {
                let start = (this.currentPage - 1) * this.pageSize;
                return this.items.slice(start, this.pageSize + start);
            },
            /**
             * 是否有数据
             * @returns {boolean}
             */
            blank: function () {
                if(this.items.length === 0) {
                    return false;
                }
                return true;
            }
        }
    }
</script>