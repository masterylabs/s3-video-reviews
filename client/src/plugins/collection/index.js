import vuex from './vuex/index'

export default {
  context: require.context('./', true, /\.vue$/i),
  vuex,
}
