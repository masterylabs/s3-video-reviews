// test url
// http://localhost:8080/?page=my-custom-slug#/brand/admin

const state = {
  ready: false,
  activeOnLoad: false,
  settings: null,
  addons: null,
  fields: null,
  unbraded: null,
  roles: [],
  settingsStr: '',
  _app: null,
}

const getters = {
  ready({ ready }) {
    return ready
  },
  settings({ settings }) {
    return settings
  },
  fields({ fields }) {
    return fields || {}
  },
  colorFields({ fields }) {
    return fields && fields.colors ? fields.colors : []
  },
  hasChanges({ settings, settingsStr }) {
    return settingsStr !== JSON.stringify(settings)
  },
}

const mutations = {
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
  SET_SETTING({ settings }, [key, value]) {
    settings[key] = value
  },
  CLEAR_CHANGES(state) {
    state.settingsStr = JSON.stringify(state.settings)
  },
}

const actions = {
  async load({ commit }) {
    const { data } = await this._vm.$app.get(`brand`)

    commit('SET', data)

    // set defaultValues
    for (const k in data.fields) {
      data.fields[k].forEach((field) => {
        if (field.default_value && !data.settings[field.value]) {
          commit('SET_SETTING', [field.value, field.default_value])
        }
      })
    }

    commit('CLEAR_CHANGES')
    commit('SET', { ready: true, activeOnLoad: data.settings.is_active })

    //

    //.theme.themes.light
  },

  async saveSettings({ commit, state: { settings } }) {
    const form = { ...settings }
    await this._vm.$app.post('brand/settings', form)

    const settingsStr = JSON.stringify(form)
    commit('SET', { settingsStr })
  },
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
