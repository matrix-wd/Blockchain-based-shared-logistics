<style lang="less">
    @import '../../../less/index.less';
    #user-map {
        padding-bottom: 30px;
        h4 {
            padding: 50px 0 30px 0;
            color: black;
            font-weight: 600;
        }
        #mapBox {
            height: 500px;
        }
    }
</style>

<template>
    <div id="user-map">
        <Row>
            <Col span="20" offset="2">
                <h4>位置信息</h4>
            </Col>
            <Col span="20" offset="2" id="mapBox"></Col>
        </Row>
    </div>
</template>

<script>

    import { Map } from '../../map.js';

    export default {
        data() {
            return {

            }
        },
        mounted: function () {
            this.$nextTick(function() {
                const _this = this;
                Map().then(AMap => {
                    let GaudetMap = new AMap.Map('mapBox', {
                        center: [116.39, 39.9],
                        zoom: 11,
                    });

                    let geocoder = new AMap.Geocoder({
                        // city: "010", //城市设为北京，默认：“全国”
                    });
                    geocoder.getLocation(_this.address, function(status, result) {
                        if (status === 'complete' && result.geocodes.length) {
                            let marker = new AMap.Marker();
                            GaudetMap.add(marker);
                            marker.setPosition(result.geocodes[0].location);
                            GaudetMap.setFitView(marker);
                        }
                    });
                });
            });
        },
        methods: {

        },
        props: {
            /**
             * 地址
             */
            address: {
                type: String
            }
        }
    }
</script>