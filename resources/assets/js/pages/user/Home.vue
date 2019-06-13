
<template>
    <div id="home">
        <Layout>
            <userIndexHeader></userIndexHeader>
            <userContent></userContent>
            <userFooter></userFooter>
            <BackTop></BackTop>
        </Layout>
    </div>
</template>

<script>
    import userIndexHeader from '../../components/user/user-index-header.vue';
    import userContent from '../../components/user/user-content.vue';
    import userFooter from '../../components/user/user-footer.vue';
    export default {
        data() {
            return {

            }
        },
        components: {
            userIndexHeader,
            userContent,
            userFooter
        }
    }
</script>