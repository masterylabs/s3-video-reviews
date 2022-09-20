import getBuckets from './GetBuckets'

const state = {}

const getters = {
  auth(_, __, { settings }) {
    if (!settings.aws_access_key || !settings.aws_secret) {
      return null
    }

    return {
      // region: 'us-east-1', // settings.aws_region,
      credentials: {
        accessKeyId: settings.aws_access_key,
        secretAccessKey: settings.aws_secret,
      },
    }
  },

  credentials(_, __, { settings }) {
    if (!settings.aws_access_key || !settings.aws_secret) {
      return null
    }

    return {
      accessKeyId: settings.aws_access_key,
      secretAccessKey: settings.aws_secret,
    }
  },

  // error({ error }) {
  //   if (!error) {
  //     return false
  //   }

  //   if (typeof error === 'string') {
  //     if (error.indexOf('Error: No value provided for input HTTP label') > -1) {
  //       return 'Possibly a CORS error'
  //     }
  //   }

  //   return 'Unable to connect'
  // },
}

const mutations = {
  SET_ERROR(state, err) {
    state.error = err
  },
}

const actions = {
  ...getBuckets,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
