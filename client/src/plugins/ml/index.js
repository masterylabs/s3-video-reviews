import App from './app'

const install = (Vue, options = {}) => {
  Vue.prototype.$app = new App(Vue, options)
}

export default {
  install,
}
