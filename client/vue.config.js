module.exports = {
  transpileDependencies: ['vuetify'],
  productionSourceMap: false,
  filenameHashing: false,
  outputDir: '../src/public/client',
  publicPath: '',
  pages: {
    app: {
      entry: 'src/main.js',
      // entry: 'src/adam/app.js',
      template: 'public/index.html',
      filename: 'index.html',
      title: 'Index',
      chunks: ['chunk-vendors', 'chunk-common', 'app'],
    },
    live: {
      entry: 'src/live.js',
      template: 'public/live.html',
      filename: 'live.html',
      title: 'Live',
      chunks: ['chunk-vendors', 'chunk-common', 'live'],
    },
    preview: {
      entry: 'src/live.js',
      template: 'public/preview.html',
      filename: 'preview.html',
      title: 'Preview',
      chunks: ['chunk-vendors', 'chunk-common', 'live'],
    },
  },
  //
  // devServer: {
  //   open: process.platform === 'darwin',
  //   host: '0.0.0.0',
  //   port: 8085, // CHANGE YOUR PORT HERE!
  //   https: true,
  //   hotOnly: false,
  // },
}
