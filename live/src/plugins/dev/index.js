import { loadComponents } from '../helpers'
const components = import.meta.globEager(`./**/*.vue`)

export default {
  install(app) {
    loadComponents(app, components, 'Dev')
  },
}
