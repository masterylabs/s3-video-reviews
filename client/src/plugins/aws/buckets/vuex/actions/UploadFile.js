export default {
  async uploadFile({ commit, state: { bucket } }, payload) {
    const res = await bucket.uploadObject(payload)

    if (!res) {
      return false
    }

    const newObject = await bucket.getObjectListFormat(payload.Key)

    if (newObject) {
      commit('ADD_OBJECT', newObject)
    }

    return true
  },
}
