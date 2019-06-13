<style lang="less">
    @import "../../../less/index.less";
    #Dashboard {
        .header {
            position: fixed;
            width: 100%;
            background-color: #222;
            opacity: 0.8;
            z-index: 2;
            .avatar-box {
                position: relative;
                width: 200px;
                height: 100%;
                margin-right: 150px;
                float: right;
                z-index: 5;
            }
        }
        .sider {
            /*background-color: #222;*/
        }
        .content {
            margin: 98px 20px 40px;
            background-color: #fff;
            min-height: 550px;
        }
        .layout-logo-left{
            width: 90%;
            height: 30px;
            background: #5b6270;
            border-radius: 3px;
            margin: 15px auto;
        }
        .menu-icon{
            transition: all .3s;
        }
        .rotate-icon{
            transform: rotate(-90deg);
        }
        .menu-item span{
            display: inline-block;
            overflow: hidden;
            width: 69px;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: bottom;
            transition: width .2s ease .2s;
        }
        .menu-item i{
            transform: translateX(0px);
            transition: font-size .2s ease, transform .2s ease;
            vertical-align: middle;
            font-size: 16px;
        }
        .collapsed-menu span{
            width: 0;
            transition: width .2s ease;
        }
        .collapsed-menu i{
            transform: translateX(5px);
            transition: font-size .2s ease .2s, transform .2s ease .2s;
            vertical-align: middle;
            font-size: 22px;
        }
    }
</style>
<template>
    <div id="Dashboard">
        <Layout>
            <Sider class="sider" ref="side1" hide-trigger collapsible :collapsed-width="78" v-model="isCollapsed">
                <Menu @on-select="selectMenu" active-name="1-1" theme="dark" width="auto" :class="menuitemClasses">
                    <MenuItem name="1-1">
                        <Icon type="md-apps" />
                        <span>仪表盘</span>
                    </MenuItem>
                    <Submenu name="2">
                        <template slot="title">
                            <Icon type="ios-checkmark-circle" />
                            <span>资源审核</span>
                        </template>
                        <MenuItem name="2-1">
                            <Icon type="ios-send" />
                            <span>运输资源</span>
                        </MenuItem>
                        <MenuItem name="2-2">
                            <Icon type="logo-codepen" />
                            <span>仓储资源</span>
                        </MenuItem>
                    </Submenu>
                    <Submenu name="3">
                        <template slot="title">
                            <Icon type="ios-cart" />
                            <span>订单管理</span>
                        </template>
                        <MenuItem name="3-1">
                            <Icon type="ios-navigate" />
                            <span>运输订单</span>
                        </MenuItem>
                        <MenuItem name="3-2">
                            <Icon type="md-radio-button-on" />
                            <span>仓储订单</span>
                        </MenuItem>
                    </Submenu>
                    <MenuItem name="4-1">
                        <Icon type="ios-people" />
                        <span>用户管理</span>
                    </MenuItem>
                    <MenuItem name="5-1">
                        <Icon type="ios-bonfire" />
                        <span>合约管理</span>
                    </MenuItem>
                </Menu>
            </Sider>
            <Layout>
                <Header class="header">
                    <Icon @click.native="collapsedSider" :class="rotateIcon" type="md-menu" size="24"></Icon>
                    <div class="avatar-box">
                        <Dropdown @on-click="userMenu">
                            <a href="javascript:void(0)">
                                <Icon type="md-contact" />
                                {{telephone}}
                                <Icon type="ios-arrow-down"></Icon>
                            </a>
                            <DropdownMenu slot="list">
                                <DropdownItem name="logout">退出</DropdownItem>
                            </DropdownMenu>
                        </Dropdown>
                    </div>
                </Header>
                <Content class="content">
                    <adminDashboard v-show="showStatus.showDashboard"></adminDashboard>
                    <adminResource :resourceType="resourceType" v-show="showStatus.showResource"></adminResource>
                    <adminOrder :orderType="orderType" v-show="showStatus.showOrder"></adminOrder>
                    <adminUser v-show="showStatus.showUser"></adminUser>
                    <adminContract v-show="showStatus.showContract"></adminContract>
                </Content>
                <UserFooter></UserFooter>
            </Layout>
        </Layout>
    </div>
</template>

<script>

    import AdminAPI from '../../api/admin.js';
    import UserFooter from '../../components/user/user-footer.vue';
    import adminDashboard from '../../components/admin/admin-dashboard.vue';
    import adminResource from '../../components/admin/admin-resource.vue';
    import adminOrder from '../../components/admin/admin-order.vue';
    import adminUser from '../../components/admin/admin-user.vue';
    import adminContract from '../../components/admin/admin-contract.vue';
    export default {
        data() {
            return {
                isCollapsed: false,
                resourceType: 'conveyance',
                orderType: 'conveyance',
                showStatus: {
                    showDashboard: true,
                    showResource: false,
                    showOrder: false,
                    showUser: false,
                    showContract: false
                }
            }
        },
        mounted: function() {
            this.loginStatus();
        },
        methods: {
            /**
             * 用户登录状态
             */
            loginStatus: function() {
                let _this = this;
                AdminAPI.loginStatus().then( function(response){
                    if(response.data.errCode === 0) {
                        _this.$store.commit('adminLoginSuccess', response.data.data);
                    } else {
                        _this.$router.push('/admin');
                    }
                }).catch( function(){
                    _this.$Message.warning('请求出现异常');
                });
            },
            /**
             * 用户菜单
             */
            userMenu: function(name) {
                if(name === 'logout') {
                    let _this = this;
                    AdminAPI.logout().then( function(response){
                        if(response.data.errCode === 0) {
                            _this.$router.back();
                        }
                    }).catch( function(){
                        _this.$Message.warning('请求出现异常');
                    });
                }
            },
            /**
             * 是否收起菜单栏
             */
            collapsedSider: function () {
                this.$refs.side1.toggleCollapse();
            },
            /**
             *  选择菜单
             */
            selectMenu: function (name) {
                this.hiddenAll();
                if(name === '1-1') {
                    this.showStatus.showDashboard = true;
                } else if(name === '2-1' || name === '2-2') {
                    this.showStatus.showResource = true;
                    if(name === '2-1') {
                        this.resourceType = 'conveyance';
                    } else {
                        this.resourceType = 'warehouse';
                    }
                } else if(name === '3-1' || name === '3-2') {
                    this.showStatus.showOrder = true;
                    if(name === '3-1') {
                        this.orderType = 'conveyance';
                    } else {
                        this.orderType = 'warehouse';
                    }
                } else if(name === '4-1') {
                    this.showStatus.showUser = true;
                } else if(name === '5-1') {
                    this.showStatus.showContract = true;
                }
            },
            /**
             * 隐藏全部
             */
            hiddenAll: function () {
                for(let key in this.showStatus) {
                    this.showStatus[key] = false;
                }
            }
        },
        computed: {
            rotateIcon:function ()  {
                return [
                    'menu-icon',
                    this.isCollapsed ? 'rotate-icon' : ''
                ];
            },
            menuitemClasses:function ()  {
                return [
                    'menu-item',
                    this.isCollapsed ? 'collapsed-menu' : ''
                ]
            },
            telephone: function() {
                let telephone = this.$store.state.admin.admin.telephone;
                if(telephone) {
                    return telephone.slice(0, 3) + '***' + telephone.slice(7, 11);
                }
                return telephone;
            }
        },
        components: {
            adminDashboard,
            adminResource,
            adminOrder,
            adminUser,
            adminContract,
            UserFooter
        }
    }
</script>