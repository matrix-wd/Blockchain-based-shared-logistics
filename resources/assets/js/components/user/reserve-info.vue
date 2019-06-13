<style lang="less">
    #reserve-info {
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
    <div id="reserve-info">
        <Row>
            <Col span="20" offset="2">
                <h4>资源预定情况</h4>
                <Row class="record-title-box">
                    <Col span="6">
                        用户
                    </Col>
                    <Col v-if="type === 'warehouse'" span="6">
                        预定时间段
                    </Col>
                    <Col v-else span="6">
                        目的地
                    </Col>
                    <Col span="6">
                        预定面积
                    </Col>
                    <Col span="6">
                        预定时间
                    </Col>
                </Row>
                <template v-if="blank" v-for="item in currentData">
                    <Row class="record-box">
                        <Col span="6">
                            {{item.telephone.slice(0, 3) + '***' + item.telephone.slice(7, 11)}}
                        </Col>
                        <Col  v-if="type === 'warehouse'" span="6">
                            {{item.startDate}} ～ {{item.endDate}}
                        </Col>
                        <Col span="6"  v-else>
                            {{item.province}}{{item.city}}{{item.country}}
                        </Col>
                        <Col span="6">
                            {{item.area}}立方米
                        </Col>
                        <Col span="6">
                            {{item.created_at}}
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
            },
            type: {
                type: String
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