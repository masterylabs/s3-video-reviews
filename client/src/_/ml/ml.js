import mixin from './mixin'
import start from './start'
import api from './api'
import vuex from './vuex'
import store from '../store'

import { loadComponents } from '../helpers/loaders'
import { toCamel } from '../helpers/str'
import { openWindow } from '../helpers/window'
import { isMobile } from '../helpers/mobile'

const MlPlugin = {
  install(Vue, options = {}) {
    // components

    // modules
    store.registerModule('ml', vuex)

    const App = {
      ready: false,
      config: null,
      isMobile: isMobile(),
      ...api,
      start,
      // ...events,
      success(message) {
        store.dispatch('ml/success', message)
      },
      error(message) {
        store.dispatch('ml/error', message)
      },
      warning(message) {
        store.dispatch('ml/warning', message)
      },
      onReady(data) {
        const view = data.view ? data.view : ''
        store.commit('ml/SET', { data, view, ready: true })
      },
      onConnectError(response) {
        store.commit('ml/SET', {
          connectionError: true,
          connectionErrorMessage: response.data,
        })
      },
      open(url, options = {}) {
        openWindow(url, options)
      },
      getApiUrl(endpoint = '') {
        let url = `${this.config.route}/api`
        if (this.config.api) url += `/${this.config.api}`
        if (endpoint) url += endpoint
        return url
      },
      getAuthToken() {
        return this.config.token
      },
    }
    Vue.prototype.$app = App

    Vue.mixin(mixin)

    // Partials

    loadComponents(Vue, require.context('./partials', true, /\.vue$/i))

    if (options.modules) {
      options.modules.forEach((mod) => {
        // vuex store module
        if (mod.vuex) store.registerModule(mod.name, mod.vuex)

        // components
        const prefix = mod.prefix || toCamel(mod.name, true)

        if (mod.context) loadComponents(Vue, mod.context, prefix)
        // add module to app if needed
      })
    }

    App.start()
  },
}

export default MlPlugin
