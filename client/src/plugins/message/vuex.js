const module = {
  namespaced: true,
  state: {
    timeout: 2800,
    items: [],
    count: 0,
  },

  mutations: {
    ADD_ITEM(state, item) {
      state.items.push(item)
      state.count++
    },
    REMOVE_ITEM({ items }, id) {
      const index = items.findIndex((item) => item.id === id)
      if (index > -1) items.splice(index, 1)
    },
  },

  actions: {
    success({ dispatch }, text) {
      dispatch('addItem', { text, name: 'success' })
    },
    error({ dispatch }, text) {
      dispatch('addItem', { text, name: 'error' })
    },
    warning({ dispatch }, text) {
      dispatch('addItem', { text, name: 'warning' })
    },
    message({ dispatch }, text) {
      dispatch('addItem', { text, name: 'info' })
    },

    addItem({ commit, state }, item) {
      const id = `msg_${state.count}`
      commit('ADD_ITEM', { ...item, id, value: true })

      if (!state.timeout) return

      setTimeout(() => {
        commit('REMOVE_ITEM', id)
      }, state.timeout)
    },
    closeItem({ commit }, id) {
      commit('REMOVE_ITEM', id)
    },
  },

  getters: {
    items({ items }) {
      return items
    },
  },
}

export default module
