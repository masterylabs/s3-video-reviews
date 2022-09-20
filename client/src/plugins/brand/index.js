import Admin from './Admin.vue'
import vuex from './vuex'
const routes = [
  {
    path: '/brand/admin',
    name: 'brand-admin',
    component: Admin,
    meta: {
      menu: true,
      text: 'BRANDING',
      icon: 'mdi-storefront',
      access: ['agency', 'developer'],
    },
  },
]

export default {
  context: require.context('./components', true, /\.vue$/i),
  on: {
    start: function ({ app, data }) {
      // add routes
      app.addRoutes(routes)

      // que vuex
      app.addVuex('brand', vuex)

      app.store.commit('brand/SET', { _app: data.store.app })
    },
  },
}
