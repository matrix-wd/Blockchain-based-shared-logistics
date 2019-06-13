const ADDRESS_API = 'http://localhost:8081/api/address/';

export default {
    /**
     * 获取省份信息
     */
    getProvince: function () {
        return axios.get(ADDRESS_API + 'province');
    },

    /**
     * 获取城市信息
     * @param privinceCode
     * @returns {*}
     */
    getCity: function (privinceCode) {
        return axios.get(ADDRESS_API + 'city/' + privinceCode);
    },

    /**
     * 获取地区信息
     * @param cityCode
     * @returns {*}
     */
    getCountry: function(cityCode) {
        return axios.get(ADDRESS_API + 'country/' + cityCode);
    }
}