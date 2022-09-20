import { loadComponents } from '../helpers'
const components = import.meta.globEager(`./**/*.vue`)

export * from './create-collection'
export * from './create-collection-item'

export default {
  install(app) {
    console.log('add collection')
    loadComponents(app, components, 'm')
  },
}
