<style lang="less">
    #user-footer {
        clear: both;
        background-color: #222222;
        opacity: 0.8;
        .footer-ul {
            padding: 30px 0;
            font-size: 15px;
            color: white;
            list-style: none;
            li {
                cursor: pointer;
                margin: 8px;
                display: inline-block;
            }
            li:first-child {
                margin-left: 0;
            }
        }
        .website-description {
            font-size: 13px;
            padding-bottom: 20px;
        }
    }
</style>

<template>
    <div id="user-footer">
        <Row>
            <Col span="20" offset="2">
                <ul class="footer-ul">
                    <li>关于骆驼</li>
                    <li>联系我们</li>
                    <li>加入我们</li>
                    <li>隐私声明</li>
                    <li>网站地图</li>
                    <li>友情链接</li>
                </ul>
            </Col>
        </Row>
        <Row>
            <Col span="20" offset="2">
                <p class="website-description">骆驼（北京）科技有限公司 | 网络经营许可证 京ICP备16057509号-2 | © Copyright©2010-2019 骆驼网Luotuo.com版权所有 | 营业执照</p>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>