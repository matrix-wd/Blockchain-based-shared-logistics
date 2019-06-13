<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>
<template>
    <div>
        <div class="demo-upload-list" v-for="(item, index) in uploadList">
            <template v-if="item.status === 'finished'">
                <img :src="item.url">
                <div class="demo-upload-list-cover">
                    <Icon type="ios-eye-outline" @click.native="handleView(index, item.url)"></Icon>
                    <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                </div>
            </template>
            <template v-else>
                <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
            </template>
        </div>
        <Upload
                ref="upload"
                :show-upload-list="false"
                :on-success="handleSuccess"
                :format="['jpg','jpeg','png']"
                :max-size="2048"
                :on-format-error="handleFormatError"
                :on-exceeded-size="handleMaxSize"
                :before-upload="handleBeforeUpload"
                multiple
                name="file"
                type="drag"
                :action="action"
                style="display: inline-block;width:58px;">
            <div style="width: 58px;height:58px;line-height: 58px;">
                <Icon type="ios-camera" size="20"></Icon>
            </div>
        </Upload>
        <Modal :title="title" v-model="visible">
            <img :src="imgUrl" style="width: 100%">
        </Modal>
    </div>
</template>
<script>
    import WarehouseAPI from '../../api/warehouse.js';
    import ConveyanceAPI from '../../api/conveyance.js';
    export default {
        data () {
            return {
                imgUrl: '',
                visible: false,
                title: '图片',
            }
        },
        props: {
            action: {
                type: String
            },
            parent: {
                type: String
            },
            uploadList: {
                type: Array
            }
        },
        methods: {
            /**
             * 查看上传图片
             * @param title
             * @param imgUrl
             */
            handleView (index, imgUrl) {
                this.title = '图片' + (index + 1);
                this.imgUrl = imgUrl;
                this.visible = true;
            },
            /**
             * 删除上传图片
             * @param file
             */
            handleRemove (file) {
                let _this = this;
                if(this.parent === 'warehouse') {
                    WarehouseAPI.deleteFile(file.name).then( function(response){
                        if(response.data.errCode === 0) {
                            _this.uploadList.splice(_this.uploadList.indexOf(file), 1);
                        }
                    }).catch( function(){
                        _this.$Message.warning('请求出现异常');
                    });
                } else if(this.parent === 'conveyance') {
                    ConveyanceAPI.deleteFile(file.name).then( function(response){
                        if(response.data.errCode === 0) {
                            _this.uploadList.splice(_this.uploadList.indexOf(file), 1);
                        }
                    }).catch( function(){
                        _this.$Message.warning('请求出现异常');
                    });
                }
            },
            /**
             * 上传成功
             * @param res
             * @param file
             */
            handleSuccess (res, file) {
                if(res.errCode === 0) {
                    file.url = 'http://localhost:8081/' + res.data;
                    file.name = res.data;
                    this.uploadList.push(file);
                    // console.log(this.uploadList);
                } else {
                    this.$Notice.warning({
                        title: '出现错误',
                        desc: '文件  ' + file.name + res.data
                    });
                }
            },
            /**
             * 格式错误
             * @param file
             */
            handleFormatError (file) {
                this.$Notice.warning({
                    title: '文件格式不正确',
                    desc: '文件 ' + file.name + ' 错误, 请上传jpg或者png格式'
                });
            },
            /**
             * 最大尺寸错误
             * @param file
             */
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: '超过大小限制',
                    desc: '文件  ' + file.name + ' 太大, 不能超过2M'
                });
            },
            /**
             * 上传张数判断
             * @returns {boolean}
             */
            handleBeforeUpload () {
                const check = this.uploadList.length < 5;
                if (!check) {
                    this.$Notice.warning({
                        title: '最多只能上传5张图片'
                    });
                }
                return check;
            }
        }
    }
</script>
