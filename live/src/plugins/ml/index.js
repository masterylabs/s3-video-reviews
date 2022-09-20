import { loadComponents } from '../helpers'
const components = import.meta.globEager(`@/components/**/*.vue`)

export default {
  install(app) {
    loadComponents(app, components, 'M')
  },
}
