import events from './events'
export default {
  ...events,

  async getItems({ commit, state: { endpoint } }) {
    commit('SET', { loading: true })
    const { data, pagin } = await this._vm.$app.get(endpoint)
    commit('SET', { loading: false, data, pagin })
  },

  removeItemById({ commit, state: { data } }, id) {
    const index = data.findIndex((a) => a.id === id)
    if (index > -1) {
      commit('REMOVE_ITEM', index)
    }
  },

  updateItem({ commit, state: { data } }, item) {
    const index = data.findIndex((a) => a.id === item.id)
    if (index > -1) {
      commit('UPDATE_ITEM', { index, value: item })
    }
  },

  refresh() {
    //
  },

  // methods
  removeItem() {},

  search() {},

  clearSearch() {},

  async load({ commit, dispatch }, payload) {
    commit('SET', payload)
    await dispatch('getItems')
    commit('SET', { ready: true })
  },
}
