<style lang="less">
    #guide {
        .content {
            color: black;
            padding: 60px 0;
            h3 {
                font-weight: 600;
            }
            p {
                font-size: 16px;
                text-indent: 2em;
                padding: 20px 0;
                line-height: 30px;
            }
            img {
                width: 100%;
            }
        }
    }
</style>
<template>
    <div id="guide">
        <userHeader></userHeader>
        <Row class="content">
            <Col span="20" offset="2">
                <h3>一、区块链简介</h3>
                <p>区块链的本质是一种特殊的分布式数据库，其主要作用是存储、读取信息。
                    区块链是由若干个节点组成的，没有中央节点，每一个节点都是平等的，且每个节点都保存着数据库的所有信息。
                    我们可以向任意节点写入信息，最后信息在所有节点进行同步。
                    由于数据在每一个节点都存在，因此最大的特定是去中心化，没有人能够对其进行恶意的篡改。</p>
                <img src="../../../img/block-chain.png" alt="block-chain"/>
                <h3>二、智能合约简介</h3>
                <p>智能合约就是部署在区块链中一段只可以执行，不可更改的代码。
                通过代码把逻辑写入区块链中，保证每个请求的公平处理。</p>
                <h3>三、骆驼物流简介</h3>
                <p>随着共享经济的到来，平台目标是打造一个基于区块链的共享物流平台，降低物流成本。
                    解决运输资源空载率高、仓储资源闲置率、信息不匹配等社会痛点问题；
                    通过采用区块链技术，解决需求方和资源方的信任危机。
                    每一笔交易数据均存储在以太坊中，交易方式采用以太币，通过智能合约的内在逻辑
                    确保需求方和资源方的利益不受到损害，确保整个交易的公平性和平台的透明性。</p>
            </Col>
        </Row>
        <userFooter></userFooter>
    </div>
</template>

<script>
    import userHeader from '../../components/user/user-header.vue';
    import userFooter from '../../components/user/user-footer.vue';
    export default {
        data() {
            return {

            }
        },
        components: {
            userHeader,
            userFooter
        }
    }
</script>