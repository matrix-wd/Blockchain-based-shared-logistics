const TOOLS_API = 'http://localhost:8081/api/tools/';

export default {
    /**
     * 人民币和以太币相互转换
     */
    RmbToEth: function (value, type) {
        return axios.get(TOOLS_API + 'RmbToEth');
    },

}