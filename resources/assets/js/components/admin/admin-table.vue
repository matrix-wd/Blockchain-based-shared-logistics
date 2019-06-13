<style lang="less">
    @import "../../../less/index.less";
    #admin-table {
        position: relative;
        z-index: 0;
    }
</style>
<template>
    <div id="admin-table">
        <i-table border :content="self" :columns="columns" :data="tableData"></i-table>
        <div style="margin: 10px;overflow: hidden">
            <div style="float: right;">
                <Page :total="totalNumber" :page-size="pageSize" :current="currentPage" @on-change="changePage"></Page>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        data() {
            return {
                self: this,
                currentPage: 1,
            }
        },
        props: {
            columns: {
                type: Array
            },
            parent: {
               type: String
            },
            data: {
                type: Array
            }
        },
        methods: {
            /**
             * 改变页码
             */
            changePage: function (page) {
                this.currentPage = page;
                if(this.parent === 'resource') {
                    this.$store.commit('setCurrentPage', this.currentPage);
                }
            },
        },
        computed: {
            totalNumber: function () {
                return this.data.length;
            },
            tableData: function () {
                let start = ( this.currentPage - 1 ) * this.pageSize;
                return this.data.slice(start, this.pageSize + start);
            },
            pageSize: function() {
                if(this.parent === 'item') {
                    return 8;
                }
                return this.$store.state.admin.pageSize;
            }
        }
    }
</script>