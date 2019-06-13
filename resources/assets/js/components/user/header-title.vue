<style lang="less">
    @import '../../../less/index.less';
    #header-title {
        .type-box {
            margin-bottom: 60px;
            background-color: #eee;
            padding: 30px 0;
            .img-logo {
                width: 150px;
                cursor: pointer;
            }
            .type-ul {
                position: relative;
                top: 10px;
                display: inline-block;
                li {
                    cursor: pointer;
                    list-style: none;
                    float: left;
                    margin-left: 30px;
                    font-size: 16px;
                }
                .active {
                    color: @primary-color;
                }
            }
        }
        .title-box {
            padding-top: 30px;
            clear: left;
            text-align: center;
            .title {
                font-size: 32px;
                padding-bottom: 20px;
                color: black;
                font-weight: 600;
            }
            p {
                font-size: 16px;
            }
        }
    }
</style>

<template>
    <div id="header-title">
        <userHeader></userHeader>
        <Row class="type-box">
            <Col span="20" offset="2">
                <img src="../../../img/logo.png" @click="goHome" alt="logo" class="img-logo" />
            </Col>
            <div class="title-box">
                <h4 class="title">{{title}}</h4>
                <p>{{info}}</p>
            </div>
        </Row>
    </div>
</template>


<script>
    import userHeader from './user-header.vue';
    export default {

        methods: {
            goHome: function () {
                this.$router.push('/');
            }
        },
        components: {
            userHeader
        },
        props: {
            title: {
                type: String
            },
            info: {
                type: String
            }
        }
    }
</script>