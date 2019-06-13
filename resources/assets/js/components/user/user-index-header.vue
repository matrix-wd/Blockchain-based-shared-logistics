<style lang="less">
    @import '../../../less/index.less';
    #user-index-header-box {
        background: url("../../../img/home/index.png") no-repeat 100%;
        color: white;
        padding: 40px 0 100px 0;
        .logo-box {
            .logo-img {
                cursor: pointer;
                width: 150px;
            }
            .position-box {
                margin-top: 2px;
                height: 24px;
                border-radius: 20px;
                background-color: #2a2a2a;
                opacity: 0.4;
                padding: 5px 10px 5px 8px;
                color: white;
                cursor: pointer;
            }
        }
        .title-box {
            margin-top: 150px;
            text-align: center;
            h1 {
                font-size: 58px;
                font-weight: 600;
            }
            h4 {
                padding-top: 20px;
                font-size: 24px;
            }
        }
        .search-box {
            margin: 50px 0;
            .search-type-box {
                color: gray;
                .search-type-ul {
                    font-size: 14px;
                    li {
                        list-style: none;
                        cursor: pointer;
                        display: inline-block;
                        cursor: pointer;
                        margin-right: 18px;
                    }
                    li:hover {
                        color: white;
                    }
                    .active {
                        color: white;
                    }
                }
            }
            .search-input-box {
                margin-top: 12px;
                .search-input {
                    color: black;
                    display: inline-block;
                    width: 80%;
                    height: 46px;
                    border-radius: 3px 0 0 3px;
                    padding-left: 12px;
                    font-size: 12px;
                    border: none;
                    outline: none;
                }
                .search-button {
                    position: relative;
                    top: 3px;
                    left: -4px;
                    cursor: pointer;
                    outline: none;
                    border-radius: 0 3px 3px 0;
                    border: none;
                    font-size: 18px;
                    color: white;
                    background-color: @primary-color;
                    width: 14%;
                    height: 46px;
                }
                .search-button:hover {
                    background-color: #eda035;
                }
            }
        }
    }

</style>

<template>
    <div id="user-index-header-box">
        <Row>
            <Col span="6" offset="2" class="logo-box">
                <img src="../../../img/logo.png" class="logo-img" alt="logo" />
                <span class="position-box" @click="selectCity">
                <Icon type="ios-pin" size="13" color="white"/>
                {{currentPosition}}
                </span>
            </Col>
            <Col span="14">
                <userNav></userNav>
            </Col>
        </Row>
        <Row class="title-box">
            <h1>共享物流，从骆驼开始</h1>
            <h4>杭州市有300个空闲仓库可用</h4>
        </Row>
        <Row class="search-box">
            <Col span="14" offset="5">
                <Row class="search-type-box">
                    <Col span="24">
                        <ul class="search-type-ul">
                            <li :class="{active: warehouseStatus}" @click="searchWarehouseData">找仓储</li>
                            <li :class="{active: conveyanceStatus}" @click="searchConveyanceDaya">找运输</li>
                        </ul>
                    </Col>
                </Row>
                <Row class="search-input-box">
                    <input type="text" placeholder="请输入您的需求" v-model="searchInfo" class="search-input" v-on:keyup.enter="getSearchData" style="outline:none;" />
                    <button class="search-button" @click="getSearchData">开始搜索</button>
                </Row>
            </Col>
        </Row>
        <myMask></myMask>
    </div>
</template>

<script>
    import myMask from './my-mask.vue';
    import userNav from './user-header/user-nav';
    export default {
        data() {
            return {
                warehouseStatus: true,
                conveyanceStatus: false,
                searchInfo: '',
            }
        },
        methods: {
            /**
             * 选择城市
             */
            selectCity: function() {
                this.$router.push('/city');
            },
            searchWarehouseData: function() {
                this.conveyanceStatus = false;
                this.warehouseStatus = true;
            },
            searchConveyanceDaya: function() {
               this.warehouseStatus = false;
               this.conveyanceStatus = true;
            },
            /**
             * 获取搜索数据
             */
            getSearchData: function () {
                if(this.conveyanceStatus) {
                    this.$router.push('/conveyance');
                } else if(this.warehouseStatus) {
                    this.$router.push('/warehouse');
                }
                this.$store.commit('setSearchInfo', this.searchInfo);
            }
        },
        computed: {
            /**
             *  当前位置
             */
            currentPosition: function() {
                return this.$store.state.home.currentCity;
            },
            
        },
        components: {
            userNav,
            myMask
        }
    }
</script>