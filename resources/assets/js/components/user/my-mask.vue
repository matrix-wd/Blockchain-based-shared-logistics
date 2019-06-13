<style lang="less">
    .mask {
        z-index: 2;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        opacity: 0.6;
        /*opacity: 1;*/
    }
</style>

<template>
    <div class="mask" @click="hiddenMask" v-show="maskStatus"></div>
</template>

<script>

    export default {
        data() {
            return {

            }
        },
        methods: {
            hiddenMask: function () {
                this.$store.dispatch('maskAction');
            }
        },
        computed: {
            /**
             * 遮罩的状态
             * @returns {default.computed.maskStatus|(function())|maskStatus|boolean|__webpack_exports__.default.computed.maskStatus}
             */
            maskStatus: function() {
                // return true;
                return this.$store.state.user.maskStatus;
            }
        }
    }
</script>