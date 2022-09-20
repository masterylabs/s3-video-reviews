import { isFolder } from '../../helpers'
import Bucket from '../../models/Bucket'
import { baseState } from '../index'

export default {
  async getItem(_, id) {
    try {
      const res = await this._vm.$app.get(`/buckets/${id}`)
      return res && res.data ? res.data : false
    } catch {
      return false
    }
  },

  async loadItem({ dispatch, commit, rootGetters }, id) {
    commit('SET', { loading: true })

    const data = await dispatch('getItem', id)

    if (!data) {
      commit('SET', { loading: false })
      return false
    }

    if (!data.meta.folders) {
      data.meta.folders = []
    }
    if (!data.meta.posters) {
      data.meta.posters = []
    }

    commit('SET', { data })

    const bucketAuth = {
      credentials: rootGetters['aws/credentials'],
      region: data.region,
    }

    const bucket = new Bucket(data.name, bucketAuth)

    commit('SET', { bucket })

    return dispatch('loadBucket')
  },

  async loadBucket({ commit, dispatch, state: { bucket, data } }) {
    try {
      const objects = await bucket.listObjects()

      if (!objects) {
        if (bucket.error) {
          this._vm.$app.error(bucket.error)
        }

        return false
      }

      objects.forEach((obj) => {
        if (isFolder(obj.Key)) {
          const exists = data.meta.folders.findIndex((a) => a.Key === obj.Key)
          if (exists < 0) {
            commit('FOLDER_META_PLACEHOLDER', obj.Key)
          }
        }
      })

      await dispatch('getBucketStatus')

      commit('SET', { objects, loading: false })

      return true
    } catch (err) {
      if (bucket.error) {
        this._vm.$app.error(bucket.error)
      }
      return false
    }
  },

  clearItem({ commit }) {
    const state = { ...baseState }
    delete state.uploads

    commit('SET', state)
  },

  async updateItem({ state }) {
    const form = { ...state.data }
    await this._vm.$app.bgPost(`buckets/${form.id}`, form)
  },
}
