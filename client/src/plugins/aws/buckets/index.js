import routes from './routes'
import vuex from './vuex'
export default {
  name: 'awsBuckets',
  // routes,
  vuex,
  context: [
    require.context('./components', true, /\.vue$/i),
    require.context('./layouts', true, /\.vue$/i),
    require.context('./forms', true, /\.vue$/i),
    require.context('./files', true, /\.vue$/i),
    ['', require.context('./bucket', true, /\.vue$/i)],
    ['', require.context('./folder', true, /\.vue$/i)],
    ['', require.context('./website', true, /\.vue$/i)],
    ['buckets', require.context('./file-editor', true, /\.vue$/i)],
    ['buckets', require.context('./image-editor', true, /\.vue$/i)],
    ['', require.context('./video', true, /\.vue$/i)],
    ['', require.context('./audio', true, /\.vue$/i)],
    // ['Test', require.context('./tests', true, /\.vue$/i)],
  ],
}
