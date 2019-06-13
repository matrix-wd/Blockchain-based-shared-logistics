<style lang="less">
    @import '../../../less/index.less';
    #selectCondition {
        margin-top: 50px;
        .ivu-form-item{
            margin-bottom: 8px;
            color: #666;
            font-weight: 200;
            .ivu-form-item-label {
                color: black;
                font-size: 14px;
                font-weight: 600;
            }
        }
    }
</style>

<template>
    <div id="selectCondition">
        <Form :label-width="100" ref="condition" v-model="condition" label-position="left">
            <FormItem :label=" label + '长度'">
                <Slider @on-change="changeLength" :min="minValue" :max="maxLength" v-model="condition.length" range></Slider>
            </FormItem>
            <FormItem :label=" label + '宽度'">
                <Slider @on-change="changeWidth" :min="minValue" :max="maxWidth" v-model="condition.width" range></Slider>
            </FormItem>
            <FormItem :label=" label + '高度'">
                <Slider @on-change="changeHeight" :min="minValue" :max="maxHeight" v-model="condition.height" range></Slider>
            </FormItem>
            <FormItem :label="label + '最大载重'" v-if="conveyanceCondition">
                <Slider @on-change="changeWeight" :min="minValue" :max="maxWeight" v-model="condition.weight" range></Slider>
            </FormItem>
            <FormItem :label="label + '价格(元)'">
                <Slider @on-change="changePrice" :min="minValue" :max="maxPrice" v-model="condition.price" range></Slider>
            </FormItem>
            <FormItem label="所属单位">
                <CheckboxGroup @on-change="changeCategory" v-model="condition.category">
                    <Checkbox label="公司"></Checkbox>
                    <Checkbox label="个人"></Checkbox>
                </CheckboxGroup>
            </FormItem>
            <FormItem :label="label + '环境'" v-if="warehouseCondition">
                <CheckboxGroup @on-change="changeEnvironment" v-model="condition.environment">
                    <Checkbox label="干燥"></Checkbox>
                    <Checkbox label="通风"></Checkbox>
                </CheckboxGroup>
            </FormItem>
            <FormItem :label="label + '类型'" v-if="conveyanceCondition">
                <CheckboxGroup @on-change="changeType" v-model="condition.type">
                    <Checkbox label="大货车"></Checkbox>
                    <Checkbox label="普通货车"></Checkbox>
                    <Checkbox label="小货车"></Checkbox>
                    <Checkbox label="面包车"></Checkbox>
                    <Checkbox label="其他"></Checkbox>
                </CheckboxGroup>
            </FormItem>
        </Form>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                minValue: 0,
                condition: {
                    length: [0, 0],
                    width: [0, 0],
                    height: [0, 0],
                    weight: [0, 0],
                    price: [0, 0],
                    category: [],
                    environment: [],
                    type: [],
                }
            }
        },
        methods: {
            /**
             * 改变长度
             */
            changeLength: function(value) {
                if(this.conveyanceCondition) {
                    this.$store.commit('changeConveyanceConditionLength', value);
                } else {
                    this.$store.commit('changeWarehouseConditionLength', value);
                }
                this.$emit('getData');
            },
            /**
             * 改变宽度
             */
            changeWidth: function (value) {
                if(this.conveyanceCondition) {
                    this.$store.commit('changeConveyanceConditionWidth', value);
                } else {
                    this.$store.commit('changeWarehouseConditionWidth', value);
                }
                this.$emit('getData');
            },
            /**
             * 改变高度
             */
            changeHeight: function(value) {
                if(this.conveyanceCondition) {
                    this.$store.commit('changeConveyanceConditionHeight', value);
                } else {
                    this.$store.commit('changeWarehouseConditionHeight', value);
                }
                this.$emit('getData');
            },
            /**
             * 改变载重
             */
            changeWeight: function(value) {
                this.$store.commit('changeConveyanceConditionWeight', value);
                this.$emit('getData');
            },
            /**
             * 改变价格
             */
            changePrice: function (value) {
                if(this.conveyanceCondition) {
                    this.$store.commit('changeConveyanceConditionPrice', value);
                } else {
                    this.$store.commit('changeWarehouseConditionPrice', value);
                }
                this.$emit('getData');
            },
            /**
             * 改变类别
             */
            changeCategory: function (value) {
                if(value.length === 0) {
                    value = ['公司', '个人'];
                }
                if(this.conveyanceCondition) {
                    this.$store.commit('changeConveyanceConditionCategory', value);
                } else {
                    this.$store.commit('changeWarehouseConditionCategory', value);
                }
                this.$emit('getData');
            },
            /**
             * 改变环境
             */
            changeEnvironment: function (value) {
                if(value.length === 2) {
                    value = ['干燥' , '通风'];
                }
                this.$store.commit('changeWarehouseConditionEnvironment', value);
                this.$emit('getData');
            },
            /**
             * 改变种类
             */
            changeType: function (value) {
                if(value.length === 0) {
                    value = ['大货车', '普通货车', '小货车', '面包车', '其他'];
                }
                this.$store.commit('changeConveyanceConditionType', value);
                this.$emit('getData');
            }
        },
        props: {
            /**
             * 仓储模块调用
             */
            warehouseCondition: {
                type: Boolean,
                default: function() {
                    return false;
                }
            },
            /**
             * 运输模块调用
             */
            conveyanceCondition: {
                type: Boolean,
                default: function() {
                    return false;
                }
            }
        },
        computed: {
            label: function () {
                if(this.warehouseCondition) {
                    return '仓库';
                }
                return '车辆';
            },
            maxLength: function () {
                if(this.warehouseCondition) {
                    return this.$store.state.warehouse.selectWarehouseData.maxLength;
                }
                return this.$store.state.conveyance.selectConveyanceData.maxLength;
            },
            maxWidth: function () {
                if(this.warehouseCondition) {
                    return this.$store.state.warehouse.selectWarehouseData.maxWidth;
                }
                return this.$store.state.conveyance.selectConveyanceData.maxWidth;
            },
            maxHeight: function() {
                if(this.warehouseCondition) {
                    return this.$store.state.warehouse.selectWarehouseData.maxHeight;
                }
                return this.$store.state.conveyance.selectConveyanceData.maxHeight;
            },
            maxWeight: function() {
                return this.$store.state.conveyance.selectConveyanceData.maxWeight;
            },
            maxPrice: function () {
                if(this.warehouseCondition) {
                    return this.$store.state.warehouse.selectWarehouseData.maxPrice;
                }
                return this.$store.state.conveyance.selectConveyanceData.maxPrice;
            },
        }
    }
</script>