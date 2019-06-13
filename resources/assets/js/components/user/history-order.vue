<style lang="less">
    @import '../../../less/index.less';
    #createResourceHint {
        .process {
            text-align: center;
        }
        .hint-info-box {
            margin: 50px 0;
            .divider-line {
                padding-bottom: 30px;
            }
        }
        .btn-box {
            margin: 100px 0;
            text-align: center;
            .create-btn {
                height: 60px;
                outline: none;
                width: 140px;
                font-size: 14px;
                background-color: @primary-color;
                color: white;
                border: none;
                border-radius: 3px;
            }
        }
    }
</style>

<template>
    <div id="createResourceHint">
        <Row>
            <Col span="24">
                <headerTitle :title="title" :info="info"></headerTitle>
            </Col>
        </Row>
        <Row class="process">
            <Col offset="2" span="5">
                <iCircle :percent="25" stroke-color="#f8ab41">
                    <span style="font-size:16px">资源发布</span>
                </iCircle>
            </Col>
            <Col span="5">
                <iCircle :percent="50" stroke-color="#f8ab41">
                    <span style="font-size:16px">后台审查</span>
                </iCircle>
            </Col>
            <Col span="5">
                <iCircle :percent="75" stroke-color="#f8ab41">
                    <span style="font-size:16px">上线出售</span>
                </iCircle>
            </Col>
            <Col span="5">
                <iCircle :percent="100" stroke-color="#f8ab41">
                    <span style="font-size:16px">平台交易</span>
                </iCircle>
            </Col>
        </Row>
        <Row class="hint-info-box" :gutter="16">
            <Divider class="divider-line">发布须知</Divider>
            <Col offset="2" span="5">
                <Card>
                    <p slot="title">信息真实完善</p>
                    <p>拥有大陆身份证号</p>
                    <p>准确填写身份证号</p>
                    <p>准确填写居住地址</p>
                </Card>
            </Col>
            <Col span="5">
                <Card>
                    <p slot="title">图片真实可靠</p>
                    <p>不得经过滤镜处理</p>
                    <p>确保图片清晰明亮</p>
                    <p>不得伪造仿造图片</p>
                </Card>
            </Col>
            <Col span="5">
                <Card>
                    <p slot="title">资源如实描述</p>
                    <p>不得夸大事实真相</p>
                    <p>准备清晰描述资源</p>
                    <p>不得虚假编造信息</p>
                </Card>
            </Col>
            <Col span="5">
                <Card>
                    <p slot="title">资源价格合理</p>
                    <p>资源价格合理工作</p>
                    <p>不得额外收取费用</p>
                    <p>价格不得随便更改</p>
                </Card>
            </Col>
        </Row>
        <Row class="btn-box">
            <Col offset="2" span="10">
                <button class="create-btn" @click="createWarehouse">仓储资源</button>
            </Col>
            <Col span="10">
                <button class="create-btn" @click="createConveyance">运输资源</button>
            </Col>
        </Row>
        <userFooter></userFooter>
    </div>
</template>


<script>
    import headerTitle from '../../components/user/header-title.vue';
    import userFooter from '../../components/user/user-footer.vue';
    export default {
        data() {
            return {
                title: '资源发布',
                info: '骆驼每天有1000+的资源发布，10000+的浏览量'
            }
        },
        methods: {
            /**
             * 发布仓储资源
             */
            createWarehouse: function () {
                this.$router.push('/createWarehouse');
            },
            /**
             * 发布运输资源
             */
            createConveyance: function () {
                this.$router.push('/createConveyance');
            }
        },
        components: {
            headerTitle,
            userFooter
        }
    }
</script>