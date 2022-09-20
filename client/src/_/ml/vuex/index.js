import auth from './auth'
import layout from './layout'
import message from './message'
import license from './license'

const state = {
  ...layout.state,
  ...message.state,
  connectionError: false,
  connectionErrorMessage: 'Unable to connect',

  ready: false,
  view: '',
  data: {
    lang: {},
  },
}

const getters = {
  ...auth.getters,
  ...layout.getters,
  ...message.getters,
  ...license.getters,
  ready({ ready }) {
    return ready
  },

  connectionError(state) {
    return state.connectionError ? state.connectionErrorMessage : false
  },

  data({ data }) {
    return data
  },

  lang({ lang }) {
    return lang
  },
  // custom views
  view({ view }) {
    return view
  },

  license({ data }) {
    if (!data.license) return false
    return data.license
  },
}

const mutations = {
  ...message.mutations,
  ...layout.mutations,
  SET(state, payload) {
    for (const k in payload) state[k] = payload[k]
  },

  SET_DATA_PROP(state, payload) {
    for (const k in payload) state.data[k] = payload[k]
  },
}

const actions = {
  ...message.actions,
  toggleView({ commit, state }, value) {
    const view = state.view == value ? '' : value
    commit('SET', { view })
    // can nofity api if needed
  },
  setView({ commit }, view) {
    commit('SET', { view })
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
