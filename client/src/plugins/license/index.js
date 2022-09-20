import vuex from './vuex'

export default {
  context: require.context('./', true, /\.vue$/i),
  vuex,
  on: {
    start: function ({ data, app }) {
      app.store.dispatch('license/start', data.license)
    },
  },
}
