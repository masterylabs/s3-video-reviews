import vuex from './vuex'

export default {
  name: 'adam',
  context: require.context('./', true, /\.vue$/i),
  vuex,
}

// add components here
