import './scss/style.scss'

export default {
  name: 'm-player',
  contextPrefix: 'MPlayer',
  context: require.context('./', true, /\.vue$/i),
}
