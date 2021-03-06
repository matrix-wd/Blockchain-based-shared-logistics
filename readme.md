# 基于区块链的共享物流（毕业设计）

## 一、介绍

随着信息技术的不断发展，我国的电子商务得到了飞速的发展，同时带动了物流行业的快速兴起。在传统的物流模式下，货运卡车装载率低，回程空载率高，仓库储存资源不能充分利用，使得物流市场成本高、效率低。因此未来的物流行业将利用信息化手段，整合资源信息，解决信息不对称问题；采用共享物流的模式，使产品所有权与使用权分离，将闲置资源合理配置，提高资源的利用效率，降低物流成本。
基于区块链的共享物流信息系统是集物流资源信息整合、仓储和运输资源服务模式创新、信任机制加强、快速检索等功能于一身的共享物流平台，采用区块链作为底层技术存储订单信息，保证信息的可追溯性和资金流的安全。
系统用户分为三类：需求方、资源方和管理方，用户以产销者的身份存在，既可以是需求方，也可以是资源方。对于需求方用户，为方便其租用资源，平台提供便利的资源检索功能，并将历史订单公开，便于其监督，此外还提供了以太币汇率转换、资源推荐和资源关注等辅助功能；对于资源方用户，为了方便其发布和管理资源，平台为其提供了资源的估价服务、上下架管理以及订单和退款申请的确认机制；对于管理方用户，即平台的管理者，平台提供资源审核、统计分析和系统管理的功能。


# 二、 技术栈

### 1. 前端

1. Vue(JavaScript框架)
2. VueX(Vue状态管理器)
3. Vue-Router(Vue路由管理器)
4. iView(UI框架)
5. npm(前端包管理工具)


### 2. 后端

1. Laravel5.5(php框架)
2. MySQL(开源数据库)
3. Composer(php包管理工具)


### 3. 智能合约

1. Solidity(智能合约代码)
2. Remix(智能合约开发框架)
3. MetaMask(以太币钱包)


### 4. 环境

1. Linux(操作系统)
2. Nginx(Web服务器)
3. 以太坊(区块链部署环境)


# 三、运行 & 构建

### 1、创建数据库
```
create database graduate
```

### 2、运行迁徙(根据迁徙文件创建数据表)
```
# 此处也可以不运行迁徙文件，可以之间导入graduate.sql
php artisan migrate
```

### 3、运行填充器(使用faker生成模拟数据)
```
php artisan db:seed
```

### 4、安装JavaScript依赖文件
```
npm install
```

### 5、创建软链接
```
# 将storage下面存储的内容链接到public目录下
eg:
ln -s ./storage/app/warehouse ./public/warehouse
ln -s ./storage/app/conveyance ./public/conveyance
```

### 6、运行
```
npm run watch
```

# 四、数据库E-R图
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/数据库.jpg" />

# 五、部分程序运行界面

### 1、系统首页
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/index.jpg" />

### 2、资源展示
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/resource.jpg" />

### 3、资源详情
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/info.jpg" />

### 4、用户中心
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/user-info.jpg" />

### 5、资源发布
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/createResource.jpg" />

### 6、仪表盘
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/user-dashboard.jpg" />

### 7、合约管理
<img src="https://github.com/deng1234/Blockchain-based-shared-logistics/blob/master/img/contract-admin.jpg" />


# 六、不足分析
1. 后端虽然采用了RESTful架构实现接口，但是却没有严格按照RESTful架构去封装接口，使用不够规范。
2. 前端和后端交互的时候应该在VueX中action去交互，但却写在组件的methods中，导致部分函数的冗余。
3. 组件模块的划分粒度没有掌握好，导致有些组件过大，有些过小。
4. 项目后期产生了惰性，和预先中还有一定的差距，应该需要严格按照时间节点去完成每一块任务。
5. 智能合约还需要完善，有部分冗余代码。
