import { loadComponents } from '../helpers/loaders'
const context = require.context('./components', true, /\.vue$/i)

export default {
  install(Vue) {
    loadComponents(Vue, context, 'Dev')
  },
}
