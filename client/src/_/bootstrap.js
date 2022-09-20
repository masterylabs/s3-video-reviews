import Vue from 'vue'
import store from './store'
import vuetify from './vuetify'
import ml from './ml/ml'
import { loadComponents } from './helpers/loaders'
import dev from './dev'
Vue.use(dev)
// components

loadComponents(Vue, require.context('../components', true, /\.vue$/i), 'm')
loadComponents(Vue, require.context('../views', true, /\.vue$/i), '', 'View')
loadComponents(
  Vue,
  require.context('../layouts', false, /\.vue$/i),
  '',
  'Layout'
)
// loadComponents(
//   Vue,
//   require.context('../layouts/partials', false, /\.vue$/i),
//   'Layout',
//   ''
// )

const start = (App, options = {}) => {
  Vue.use(ml, options.ml)

  if (options.moment) {
    Vue.use(require('vue-moment'))
  }

  const props = {
    store,
    vuetify,
    render: (h) => h(App),
  }

  const ready = () => {
    new Vue(props).$mount('#masteryl_app')
  }

  // optional router
  if (options.routes) {
    import('./router').then((router) => {
      props.router = router.default(Vue, options.routes)
      ready()
    })
  } else ready()
}

export default start
