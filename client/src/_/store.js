import Vue from 'vue'
import Vuex from 'vuex'
import modules from '../vuex'

const state = {
  loading: false,
}

const mutations = {
  SET_PROP(state, payload) {
    for (const k in payload) state[k] = payload[k]
  },
}

const actions = {
  setLoading({ commit }, loading = true) {
    commit('SET_PROP', { loading })
  },
}

Vue.use(Vuex)

export default new Vuex.Store({ state, mutations, actions, modules })
