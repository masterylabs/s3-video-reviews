import vuex from './vuex'

export default {
  contextPrefix: 'DragDrop',
  vuex,
  context: require.context('./', true, /\.vue$/i),
}
