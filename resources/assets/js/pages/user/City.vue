<style lang="less">
    @import '../../../less/index.less';
    #city {
        margin-top: 30px;
        .logo-img {
            cursor: pointer;
            position: relative;
            top: 6px;
            width: 150px;
        }
        .search-box {
            height: 60px;
            border: 1px solid #ccc;
            border-radius: 3px;
            .search-icon {
                line-height: 60px;
                padding-left: 30px;
            }
            .search-box {
                display: inline-block;
            }
            input {
                display: inline;
                background-color: white;
                border-radius: 3px;
                width: 70%;
                border: 0;
                height: 100%;
            }
            .search-btn {
                margin: 7px 10px 7px 0;
                float: right;
                font-size: 16px;
                width: 100px;
                background-color: @primary-color;
                height: 44px;
                line-height: 44px;
                color: white;
                border: none;
                border-radius: 4px;
                outline: none;
            }
        }
        .popular-city {
            margin-top: 60px;
            font-weight: 600;
            font-size: 16px;
            color: black;
            .popular-city-ul {
                margin-left: 40px;
                list-style: none;
                display: inline;
                li {
                    display: inline-block;
                    margin-right: 20px;
                    cursor: pointer;
                }
            }
        }
        .select-city-box {
            display: none;
            margin-top: 30px;
            font-weight: 600;
            font-size: 16px;
            color: black;
            .select-city-span {
                padding-right: 40px;
            }
        }
        .citys-box {
            margin-top: 50px;
            .content {
                border: 1px solid #ccc;
                border-bottom: 0;
                .item {
                    height: 60px;
                    border-bottom: 1px solid #ccc;
                    .alphabet {
                        line-height: 59px;
                        text-align: center;
                        color: #ccc;
                        display: inline-block;
                        width: 60px;
                        height: 59px;
                        font-size: 32px;
                        background-color: #efefef;
                    }
                    .alphabet:hover {
                        background-color: @primary-color;
                        color: white;
                    }
                    .province-captial {
                        display: inline-block;
                        position: relative;
                        top: -3px;
                        padding: 0 60px 0 40px;
                        font-weight: 600;
                        font-size: 18px;
                        color: black;
                    }
                    .city-ul {
                        display: inline-block;
                        li {
                            font-size: 14px;
                            float: left;
                            list-style: none;
                            margin-right: 30px;
                            cursor: pointer;
                        }
                        li:hover {
                            font-weight: 600;
                            color: @primary-color;
                        }
                    }
                }
            }
        }
    }
</style>

<template>
    <div id="city">
        <Row>
            <Col offset="2" span="2">
                <img src="../../../img/logo.png" @click="goHome" class="logo-img" alt="log" />
            </Col>
            <Col offset="1" span="14" class="search-box">
                <Icon type="ios-search-outline" class="search-icon" size="30" />
                <input type="text" placeholder="搜索城市" />
                <button class="search-btn"">搜索</button>
            </Col>
        </Row>
        <Row class="popular-city">
            <Col offset="2" span="20">
                <span>热门城市</span>
                <ul class="popular-city-ul">
                    <li>北京</li>
                    <li>杭州</li>
                    <li>上海</li>
                </ul>
            </Col>
        </Row>
        <Row class="select-city-box">
            <Col offset="2" span="20">
                <span class="select-city-span">城市选择</span>
                <Select size="large" style="width:180px" placeholder="省份">
                    <Option value="1"></Option>
                </Select>
                <Select size="large" style="width:180px" placeholder="城市">
                    <Option value="2"></Option>
                </Select>
            </Col>
        </Row>
        <Row class="citys-box">
            <Col offset="2" span="20" class="content">
                <div class="item">
                    <span class="alphabet">A</span>
                    <span class="province-captial">安徽</span>
                    <ul class="city-ul">
                        <li @click="getCity('安庆')">安庆</li>
                        <li @click="getCity('滁州')">滁州</li>
                        <li @click="getCity('合肥')">合肥</li>
                        <li>马鞍山</li>
                        <li>芜湖</li>
                    </ul>
                </div>
                <div class="item">
                    <span class="alphabet">B</span>
                    <span class="province-captial">北京</span>
                    <ul class="city-ul">
                        <li>北京</li>
                    </ul>
                </div>
                <div class="item">
                    <span class="alphabet">Z</span>
                    <span class="province-captial">浙江</span>
                    <ul class="city-ul">
                        <li>杭州</li>
                        <li>宁波</li>
                        <li>金华</li>
                    </ul>
                </div>
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
             * 点击logo返回首页
             */
            goHome: function () {
                this.$router.push('/');
            },
            /**
             * li的点击事件
             * @param city
             */
            getCity(city) {
                this.$store.commit('setCurrentCity', city);
                this.$router.push('/');
            }
        }
    }
</script>