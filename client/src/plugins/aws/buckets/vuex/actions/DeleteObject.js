export default {
  deleteObjects({ dispatch }, Keys) {
    const nextObject = async (index) => {
      const Key = Keys[index]

      await dispatch('deleteObject', Key)

      await dispatch('maybeDeleteThumb', Key)

      // check if thumb exists

      index++
      if (Keys.length > index) {
        return nextObject(index)
      }
    }

    return nextObject(0)
  },

  async maybeDeleteThumb(
    { commit, state: { bucket, objects, thumbKey } },
    itemKey
  ) {
    const Key = `${itemKey}${thumbKey}`

    if (objects.findIndex((obj) => obj.Key === Key) < 0) {
      return
    }

    const deleted = await bucket.deleteObjects([Key])

    if (deleted) {
      commit('REMOVE_OBJECT', Key)
    }

    return deleted
  },

  async deleteObject({ dispatch, commit, state: { bucket } }, Key) {
    await dispatch('maybeDeleteThumb', Key)

    const deleted = await bucket.deleteObjects([Key])

    if (deleted) {
      commit('REMOVE_OBJECT', Key)
    }

    return deleted
  },

  removeAllUploaded({ dispatch, state: { uploads } }) {
    const keys = uploads
      .filter((item) => !item.loading && item.progress === 100)
      .map((item) => item.Key)

    if (keys.length) {
      dispatch('removeUpload', keys)
    }
  },

  removeUpload({ commit }, Key) {
    if (Array.isArray(Key)) {
      Key.forEach((value) => {
        commit('REMOVE_UPLOAD', value)
      })
    } else {
      commit('REMOVE_UPLOAD', Key)
    }
  },

  async deleteFull({ dispatch }) {
    // delete bucket
    const a = await dispatch('deleteBucket')
    if (!a) {
      return false
    }

    // delete item
    await dispatch('deleteLocal')

    return true
  },

  async deleteLocal({ state: { data } }) {
    return await this._vm.$app.post(`/buckets/${data.id}/delete`)
  },

  async deleteBucket({ dispatch, state: { bucket, objects } }) {
    // remove all objects
    const keys = objects.map((a) => a.Key)
    if (keys.length) {
      await dispatch('deleteObjects', keys)
    }

    const success = await bucket.destroy()

    if (!success) {
      if (bucket.error) {
        this._vm.$app.error(bucket.error)
      }
      return false
    }

    return true
  },
}
