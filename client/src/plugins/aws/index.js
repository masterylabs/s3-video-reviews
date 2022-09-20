import vuex from './vuex/index'
import awsBuckets from './buckets'
import s3 from './s3'

const aws = {
  name: 'aws',
  vuex,
  context: require.context('./components', true, /\.vue$/i),
}

export { aws, awsBuckets, s3 }
