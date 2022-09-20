import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import ml from './plugins/ml'
import quillEditor from './plugins/quill-editor'
import localforage from 'localforage'
import { getConfig } from './plugins/ml/_helpers'
const config = getConfig('#app')
import globalMixin from './mixins/global'

// import { loadContext } from './plugins/ml/_helpers'

// custom plugins
import codeEditor from './plugins/code-editor'
import imageCompressor from './plugins/image-compressor'

// ml module plugins
import license from './plugins/license'
import message from './plugins/message'
import brand from './plugins/brand'
import collection from './plugins/collection'
// import teams from './plugins/teams'
// import login from './plugins/login'

import { aws, awsBuckets, s3 } from './plugins/aws'

// 3rd party plugins
import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

import '@babel/polyfill'

localforage.config({
  driver: localforage.LOCALSTORAGE,
  name: 's3-video-reviews',
  version: 1.0,
})

// trim down to one
Vue.prototype.$localforage = localforage
Vue.prototype.$lf = localforage

Vue.use(quillEditor)
Vue.use(codeEditor)
Vue.use(imageCompressor)

import adam from './adam'
import dragDrop from './plugins/drag-drop'
import mPlayer from './plugins/m-player'

Vue.use(ml, {
  //
  config,
  router,
  store,
  modules: {
    license,
    message,
    brand,
    collection,
    aws,
    awsBuckets,
    s3,
    // teams,
    // login,
    adam,
    'drag-drop': dragDrop,
    'm-player': mPlayer,
  },
  context: [
    //
    require.context('./components', true, /\.vue$/i),
    ['', require.context('./layouts', true, /\.vue$/i)],
  ],
})

Vue.config.productionTip = false

Vue.use(require('vue-moment'))

Vue.mixin(globalMixin)

// loadContext(Vue, )

new Vue({
  router,
  store,
  vuetify,
  render: (h) => h(App),
}).$mount('#app')
