import { slugify } from '../../helpers'

export default {
  async deleteFolder({ commit, dispatch, state }, Key) {
    const ok = await state.bucket.deleteFolder(Key)

    if (ok) {
      // remove deleted objects
      const objects = state.objects.filter((obj) => obj.Key.indexOf(Key) !== 0)
      commit('SET', { objects })
      commit('REMOVE_FOLDER_META', Key)
      await dispatch('updateItem')
    }
    //
    return ok
  },

  async createFolder(
    { commit, dispatch, state: { bucket, path }, getters: { folders } },
    // { name, meta }
    payload
  ) {
    const Key = payload.Key ? payload.Key : path + slugify(payload.name) + '/'
    const meta = payload.meta ? payload.meta : { icon: '', color: '' }
    const isBg = payload.bg

    const exists = folders.find((item) => item.Key === Key)

    if (exists) {
      if (!isBg) {
        this._vm.$app.error('Folder name already exists!')
      }
      return false
    }

    const created = await bucket.createFolder(Key)

    if (!created) return false

    // get bucket and add to objects
    const folder = await bucket.getObjectListFormat(Key)

    commit('ADD_FOLDER_META', { ...meta, Key })
    commit('ADD_OBJECT', folder)

    // save new meta
    await dispatch('updateItem')

    return Key
  },

  // async getFolder({ state: { bucket } }, Key) {
  //   // const value = await bucket.getObject(Key)
  // },
}
