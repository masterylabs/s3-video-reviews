// store module: message
import uuid from 'uuid'

export default {
  state: {
    messages: [],
  },
  getters: {
    messages({ messages }) {
      return messages
    },
  },
  mutations: {
    SET_MESSAGE(state, m) {
      state.messages.push(m)
    },
    CLOSE_MESSAGE(state, id) {
      const index = state.messages.findIndex((a) => a.id == id)
      if (index > -1) state.messages.splice(index, 1)
    },
  },

  actions: {
    success({ dispatch }, text) {
      dispatch('message', { text, name: 'success' })
    },
    error({ dispatch }, text) {
      dispatch('message', { text, name: 'error' })
    },
    warning({ dispatch }, text) {
      dispatch('message', { text, name: 'warning' })
    },
    message({ commit }, m) {
      m.id = uuid()
      commit('SET_MESSAGE', m)
      setTimeout(() => {
        commit('CLOSE_MESSAGE', m.id)
      }, 3000)
    },
  },
}
