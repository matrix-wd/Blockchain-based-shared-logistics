<style>

</style>

<template>
    <div id="user-content">
        <userContentLink></userContentLink>
        <userContentWarehouse></userContentWarehouse>
        <userContentConveyance></userContentConveyance>
    </div>
</template>

<script>
    import userContentLink from './user-content/user-content-link.vue';
    import userContentWarehouse  from './user-content/user-content-warehouse.vue';
    import userContentConveyance  from './user-content/user-content-conveyance.vue';
    export default {
        data() {
            return {

            }
        },
        components: {
            userContentLink,
            userContentWarehouse,
            userContentConveyance
        }
    }
</script>