const ATTENTION_API = 'http://localhost:8081/api/attention/';

export default {

    /**
     * 取消关注
     * @param userId
     * @param resourceId
     * @param type
     * @returns {*}
     */
    cancelAttention: function (userId, resourceId, type) {
        return axios.delete(ATTENTION_API + userId + '/' + resourceId + '/' + type);
    },

    /**
     * 关注
     * @param userId
     * @param resourceId
     * @param type
     * @returns {*}
     */
    addAttention: function (userId, resourceId, type) {
        return axios.post(ATTENTION_API + 'addAttention', {
            userId: userId,
            resourceId: resourceId,
            type: type
        });
    }

}