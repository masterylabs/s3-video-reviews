import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import config from '../config'

const colors = {
  primary: config.color || '#1D73AA',
  secondary: config.secondaryColor || '#82B1FF',
  accent: config.accentColor || '#FF5252',
  error: config.errorColor || '#FF5252',
  info: config.infoColor || '#2196F3',
  success: config.successColor || '#4CAF50',
  warning: config.warningColor || '#FFC107',
  logo: config.logoColor || '#c4302b',
  'toggle-on': '#4CAF50',
  'toggle-off': '#A0A0A0',
  'toggle-off-btn': '#dedede',
  timed: '#FFC107',
}

Vue.use(Vuetify)

export default new Vuetify({
  icons: {
    iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
  },
  theme: {
    dark: config.dark,
    options: {
      customProperties: true,
    },
    themes: {
      light: colors,
    },
  },
})

// paypal blue: #3b7bbf // WordPress: '#1D73AA', // '#1D73AA', // youtube '#c4302b', //'#635BFF', // '#578CFF', // pp: 0070ba, stripe: 635BFF, WordPress 1D73AA, nice blue:1F69FF
