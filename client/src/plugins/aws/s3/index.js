import vuex from './vuex'
import routes from './routes'

export default {
  name: 's3',
  vuex,
  context: require.context('./', true, /\.vue$/i),
  routes,
}
