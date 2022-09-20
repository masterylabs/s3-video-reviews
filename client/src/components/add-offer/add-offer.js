import Bucket from '@/plugins/aws/buckets/models/Bucket'
import {
  setBucketWebsite,
  setBucketPublic,
  setBucketPolicy,
} from '@/plugins/helpers'

const state = {
  stepper: {
    value: 0,
    dialog: false,
  },
  form: {
    bucket_name: '',
    bucket_region: '',
    // bucket_name: 's3-video-reviews',
    // bucket_region: 'us-east-1',
    bucket_cloudfront: '',
    bucket_domain: '',

    // offer
    name: '',
    prod_name: '',
    checkout_url: '',
    description: '',
  },
}

const getters = {
  stepper({ stepper }) {
    return stepper
  },
  form({ form }) {
    return form
  },
}

const mutations = {
  CLEAR_FORM(state) {
    for (const k in state.form) {
      state.form[k] = ''
    }
  },
}

const actions = {
  getBucket({ state, rootGetters }) {
    const name = state.form.bucket_name
    const auth = {
      region: state.form.bucket_region,
      credentials: rootGetters['aws/credentials'],
    }

    return new Bucket(name, auth)
  },

  async uploadBucketFiles({ dispatch }, pageId) {
    const { data } = await this._vm.$app.get(`/pages/${pageId}/files`)
    const bucket = await dispatch('getBucket')

    const onDone = () => {}

    const next = async () => {
      const item = data.pop()
      const file = new Blob([item.contents], { type: item.type })

      await bucket.uploadObject({
        Key: item.fileName,
        file,
      })

      if (!data.length) {
        return onDone()
      }

      return next()
    }

    return next()
    //
    // commit('SET', { bucketFilesQue: data })
    // dispatch('setupBucketNext')
  },

  async configureBucketForWebsite({ dispatch }, bucket = null) {
    if (!bucket) {
      bucket = await dispatch('getBucket')
    }

    await setBucketWebsite(bucket)
    await setBucketPublic(bucket)
    await setBucketPolicy(bucket)

    return true

    //
    //
  },
}
export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
