import api, { createApi } from './api'
import { getConfig, loadComponents, loadContext } from './_helpers'

class App {
  prefix = 'M'
  config = {}
  _events = {}
  _globals = {}

  connected = false

  constructor(
    Vue,
    config = {},
    availableKeys = ['config', 'store', 'router', 'vuetify']
  ) {
    this._vm = Vue
    Vue.mixin({
      methods: {
        _: function (key, na = false) {
          const u = key.toUpperCase()
          if (this.LANG && this.LANG[u]) {
            return this.LANG[u]
          }

          if (na) {
            return na
          }

          return key
        },
      },
    })

    // config can be dom el
    if (typeof config.config === 'string') {
      config.config = getConfig(config.config)
    }

    // this.$vuetify.theme.themes.light[key] = value

    //

    availableKeys.forEach((key) => {
      if (config[key]) {
        this[key] = config[key]
      }
    })

    // LOADERS

    // API

    if (this.config.api) {
      this.loadApi(this.config.api)
    }

    // Context

    if (config.context) {
      this.loadContext(config.context)
    }

    // Modules

    if (config.modules) {
      for (const k in config.modules) {
        this.loadModule(k, config.modules[k])
      }
    }

    // Intergrations
    if (config.integrations) {
      for (const k in config.integrations) {
        this.loadIntegration(k, config.integrations[k])
      }
    }

    if (config.router) {
      config.router.beforeEach((to, from, next) => {
        if (!this.canAccessRoute(to)) {
          return config.router.replace({ path: '/' })
        }

        if (window.parent && window.parent.mlhash) {
          window.parent.mlhash(to.path)
        }
        next()
      })
    }
  }

  async start(url) {
    const data = await this.get(url)

    this.connected = !!data

    if (!data) {
      return
    }

    if (data.global) {
      for (const k in data.global) {
        const upper = k.toUpperCase()
        this._vm.prototype[upper] = data.global[k]
        this._globals[k] = data.global[k]
      }
    }

    // load store vars
    if (data.store && this.store) {
      this.store.commit('SET', data.store)
    }

    if (this._events.start) {
      this.callEvent('start', data)
    }

    return data
  }

  on(key, value) {
    if (!this._events[key]) {
      this._events[key] = []
    }

    this._events[key].push(value)
  }

  callEvent(key, data) {
    const app = this
    this._events[key].forEach((func) => {
      func({ data, app })
    })
  }

  /**
   * Loaders
   */
  setAuth(token = false) {
    if (token) {
      this.setAuthHeader(token)
    } else if (this.config.token) {
      this.setAuthHeader(this.config.token)
    }

    return this
  }

  loadApi(baseURL) {
    const config = {
      authToken: this.config.token,
    }
    createApi(baseURL, config)

    // load methods
    for (const k in api) {
      this[k] = api[k]
    }
  }

  loadContext(value, prefix = false) {
    if (!prefix) prefix = this.prefix

    if (!Array.isArray(value)) {
      return loadContext(this._vm, value, prefix)
    }

    value.forEach((item) => {
      // single item
      if (!Array.isArray(item)) {
        return loadContext(this._vm, item, prefix)
      }

      // Array with custom prefix
      loadContext(this._vm, item[1], item[0])
    })
  }

  loadComponents(value, prefix = false) {
    if (!prefix) prefix = this.prefix

    loadComponents(this._vm, value, prefix)
  }

  loadModule(key, value) {
    const prefix = value.prefix || key

    // vuex

    if (value.vuex && this.store) {
      //
      this.store.registerModule(prefix, value.vuex)
    }

    if (value.context) {
      const contextPrefix =
        typeof value.contextPrefix !== 'undefined'
          ? value.contextPrefix
          : prefix
      this.loadContext(value.context, contextPrefix)
    }

    if (value.components) {
      this.loadComponents(value.components, prefix)
    }

    if (value.mount) {
      for (const k in value.mount) {
        this[k] = value.mount[k]
      }
    }

    if (value.on) {
      for (const k in value.on) {
        this.on(k, value.on[k])
      }
    }

    // routes
    if (value.routes) {
      this.addRoutes(value.routes)
    }
  }

  loadIntegration(key, value) {
    // routes
    if (value.routes) {
      this.addRoutes(value.routes)
    }

    // vuex
    if (value.vuex && this.store) {
      const moduleName = value.name || key

      this.store.registerModule(moduleName, value.vuex)
    }

    if (value.context) {
      this.loadContext(value.context, key)
    }
  }

  addVuex(name, module) {
    this.store.registerModule(name, module)
  }

  addRoutes(items) {
    items.forEach((route) => {
      this.router.addRoute(route)
    })
  }

  canAccessRoute(route) {
    if (!route.meta.access) {
      return true
    }

    const userAccess = this.store.getters.access

    const access = route.meta.access

    if (typeof access === 'string' && !userAccess[access]) {
      return false
    }

    if (Array.isArray(access)) {
      for (let i = 0; i < access.length; i++) {
        if (userAccess[access[i]]) {
          break
        }

        if (i === access.length - 1) {
          return false
        }
      }
    }

    return true
  }

  getMenuItems() {
    const itemFilter = (route) => route.meta.menu && this.canAccessRoute(route)

    const itemMap = (route) => {
      return {
        text: route.meta.text,
        icon: route.meta.icon,
        lang: route.meta.lang,
        attrs: {
          to: {
            name: route.name,
          },
          exact: !!route.meta.exact,
        },
      }
    }

    const sortMap = (a, b) => {
      const aOrder = a.meta.order || 100
      const bOrder = b.meta.order || 100
      if (aOrder < bOrder) {
        return -1
      }
      if (aOrder > bOrder) {
        return 1
      }

      // names must be equal
      return 0
    }

    return this.router.matcher
      .getRoutes()
      .sort(sortMap)
      .filter(itemFilter)
      .map(itemMap)
  }
}

export default App
