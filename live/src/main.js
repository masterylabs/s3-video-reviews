import { createApp } from 'vue'
import App from './App.vue'
import './scss/index.scss'
import { loadComponents } from './plugins/helpers'
const components = import.meta.globEager(`./components/**/*.vue`)
const vuetifyComps = import.meta.globEager(`./v/**/*.vue`)

const app = createApp(App)

loadComponents(app, components, 'c')
loadComponents(app, vuetifyComps, 'v')

app.mount('#app')
