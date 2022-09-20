import Vue from 'vue'
import Vuex from 'vuex'
import layout from './layout'
import addOffer from '../components/add-offer/add-offer'

Vue.use(Vuex)

const state = {
  ready: false,
  loading: false,
  settings: null,
  settingsStr: '',
  config: {},
  app: {},
  user: {},
  // layout: {
  //   editBucketDialog: false,
  // },
  search: {
    q: '',
    total: 0,
    loading: false,
    lastSearch: '',
  },
}

const getters = {
  search({ search }) {
    return search
  },

  ready({ ready }) {
    return ready
  },

  loading({ loading }, getters) {
    return loading ||
      getters['collection/loading'] ||
      getters['awsBuckets/loading']
      ? true
      : false
  },
  settings({ settings }) {
    return settings
  },
  user({ user }) {
    return user || {}
  },
  hasChanges({ settingsStr, settings }) {
    return settingsStr !== JSON.stringify(settings)
  },

  config({ config }) {
    return config
  },
  app({ app }) {
    return app
  },

  access({ config }) {
    // config.access.premium = true
    // config.access.developer = true
    return config.access ? config.access : {}
  },
  websiteAccess(_, { access }) {
    return access.website || access.premium ? true : false
  },

  baseUrl({ config, settings }) {
    if (!config.baseurl) {
      return ''
    }

    let url = config.baseurl

    if (settings && settings.prefix) {
      url += '/' + settings.prefix
    }
    return url
  },
}

const mutations = {
  SEARCH(state, payload) {
    for (const k in payload) {
      state.search[k] = payload[k]
    }
  },

  SEARCH_SEARCH(state) {
    state.search.lastSearch = state.search.q
  },

  SET(state, payload) {
    if (Array.isArray(payload)) {
      const [key, value] = payload
      state[key] = value
    } else {
      for (const k in payload) {
        state[k] = payload[k]
      }
    }
  },
  SET_ACCESS({ config }, access) {
    config.access = access
  },
  CLEAR_CHANGES(state) {
    state.settingsStr = JSON.stringify(state.settings)
  },
}

const actions = {
  loading({ commit }, loading = true) {
    commit('SET', { loading })
  },

  async loadSettings({ commit }) {
    commit('SET', { loading: true })
    const { data } = await this._vm.$app.get('settings')
    commit('SET', { settings: data, loading: false })
  },

  async saveSettings({ commit, state: { settings } }) {
    await this._vm.$app.post('settings', { ...settings })
    commit('CLEAR_CHANGES')
  },

  async onReady({ commit }) {
    commit('CLEAR_CHANGES')
    commit('SET', { ready: true })
  },
}

const store = new Vuex.Store({
  state,
  getters,
  mutations,
  actions,
  modules: {
    layout,
    addOffer,
  },
})

export default store
