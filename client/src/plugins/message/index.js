import vuex from './vuex'
import mount from './mount'
// import Message from './Message.vue'

export default {
  context: require.context('./', true, /\.vue$/i),
  // components: [Message],
  vuex,
  mount,
}
