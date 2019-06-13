<style lang="less">
    @import "../../../less/index.less";
    #admin-user {

    }
</style>
<template>
    <div id="admin-user">
        <adminTable :columns="columns" :data="tableData"></adminTable>
    </div>
</template>

<script>

    import UserAPI from '../../api/user.js';
    import adminTable from '../../components/admin/admin-table.vue';
    export default {
        data() {
            return {
                columns: [
                    {
                        title: '用户Id',
                        width: 100,
                        align: 'center',
                        key: 'userId',
                    },
                    {
                        title: '用户名',
                        width: 100,
                        align: 'center',
                        key: 'username'
                    },
                    {
                        title: '性别',
                        width: 70,
                        align: 'center',
                        key: 'gender'
                    },
                    {
                        title: '身份证号',
                        align: 'center',
                        key: 'idCard'
                    },
                    {
                        title: '电话号码',
                        width: 120,
                        align: 'center',
                        key: 'telephone'
                    },
                    {
                        title: '省份',
                        width: 120,
                        align: 'center',
                        key: 'province'
                    },
                    {
                        title: '城市',
                        width: 120,
                        align: 'center',
                        key: 'city',
                    },
                    {
                        title: '地区',
                        width: 120,
                        align: 'center',
                        key: 'country',
                    },
                    {
                        title: '登录次数',
                        width: 120,
                        align: 'center',
                        key: 'loginTimes',
                    },
                    {
                        title: '最后一次登录IP地址',
                        width: 150,
                        align: 'center',
                        key: 'lastLoginIp',
                    }
                ],
                tableData: []
            }
        },
        methods: {
            /**
             * 获取用户数据
             */
            getUserDataAdmin: function () {
                let _this = this;
                UserAPI.getUserDataAdmin().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.tableData = response.data.data;
                    } else {
                        _this.$Message.warning(response.data.data);
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            }
        },
        mounted: function() {
            this.getUserDataAdmin();
        },
        computed: {

        },
        components: {
            adminTable
        }
    }
</script>