const state = {
  data: null,
  updateDialog: false,
  show: false,
}

const getters = {
  valid({ data }) {
    return data && data.valid ? true : false
  },
  data({ data }) {
    return data
  },
  product({ data }) {
    return data.product ? data.product : {}
  },

  show({ show }) {
    return show
  },

  addons({ data }) {
    return data && data.addons ? data.addons : []
  },

  contact({ data }) {
    const contact = data && data.contact ? { ...data.contact } : {}

    if (contact.first_name) {
      contact.name = contact.first_name

      if (contact.last_name) {
        contact.name += ` ${contact.last_name}`
      }
    }

    if (contact.avatar) {
      const isGravitarHash = contact.avatar.indexOf('://') < 0
      if (isGravitarHash) {
        contact.avatar = `https://www.gravatar.com/avatar/${contact.avatar}?d=mp`
      }
    }

    return contact
  },
}

const mutations = {
  SET(state, payload) {
    for (const k in payload) {
      state[k] = payload[k]
    }
  },
  TOGGLE(state, key) {
    state[key] = !state[key]
  },
}

const actions = {
  start({ commit }, data) {
    commit('SET', { data })
  },

  toggleUpdateDialog({ commit }) {
    commit('TOGGLE', 'updateDialog')
  },

  async update({ commit, dispatch }, form) {
    const res = await this._vm.$app.post('client/license', form)

    if (res && res.data) {
      commit('SET', { data: res.data })
      dispatch('flash')
      return true
    }

    // invalid response
    return false
  },

  // async delete({ commit, dispatch }, form) {
  //   const res = await this._vm.$app.post('client/license', form)

  //   if (res && res.data) {
  //     commit('SET', { data: res.data })
  //     dispatch('flash')
  //     return true
  //   }

  //   // invalid response
  //   return false
  // },

  flash({ commit }, seconds = 10) {
    commit('SET', { show: true })

    setTimeout(() => {
      commit('SET', { show: false })
    }, seconds * 1000)
  },

  updateAccess() {},
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
