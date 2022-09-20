export default {
  async duplicateFile({ dispatch, commit, state: { bucket } }, Key) {
    const newKey = await dispatch('getUniqueObjectKey', Key)
    const success = await bucket.copyObject(Key, newKey)

    if (!success) {
      return false
    }

    const newObject = await bucket.getObjectListFormat(newKey)

    if (!success) {
      return false
    }

    commit('ADD_OBJECT', newObject)

    return true
  },
}
