import Vue from 'vue'
// import vuetify from '@/_/vuetify'
import vuetify from './plugins/vuetify'
// import axios from 'axios'

import { getConfig, loadComponents } from '@/_/helpers/loaders'
import { isMobile } from '@/_/helpers/mobile'
import Live from './adam/Live.vue'

// video player
import MPlayer from '@/plugins/m-player/MPlayer.vue'
import '@/plugins/m-player/scss/style.scss'
import '@/styles/app.scss'
import '@/styles/live.scss'

/**
 * DEV DEV DEV
 */

loadComponents(Vue, require.context('./adam/items', true, /\.vue$/i), 'adam')

const config = window._DATA
const isPreview = window._DATA.is_preview

Vue.prototype.$app = { config }
Vue.prototype.$isMobile = isMobile()
Vue.prototype.$isPreview = isPreview

if (window._DATA && window._DATA.public_url) {
  Vue.prototype.$public_url = window._DATA.public_url
}

// Vue.use(dev)
Vue.component('m-player', MPlayer)

loadComponents(
  Vue,
  require.context('@/plugins/m-player/components', true, /\.vue$/i),
  'MPlayer'
)

if (!isPreview) {
  const isDark = !!config.data.theme.dark

  if (isDark) {
    vuetify.framework.theme.isDark = true
  }

  const bg = config.data.bg
  const bgColor = bg.color ? bg.color : isDark ? '#121212' : ''
  document.body.style.backgroundColor = bgColor
}

new Vue({
  vuetify,
  render: (h) => h(Live),
}).$mount('#app')
