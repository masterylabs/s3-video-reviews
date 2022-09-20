const state = {
  website: {
    enabled: false,
    config: {
      ErrorDocument: {
        Key: '404.html',
      },
      IndexDocument: {
        Suffix: 'index.html',
      },
      RedirectAllRequestsTo: undefined,
      RoutingRules: undefined,
    },
  },
}

const getters = {
  website({ website }) {
    return website
  },

  showWebsite(_, { websiteEnabled, isBucketPublic }) {
    return websiteEnabled && isBucketPublic
  },

  websiteEnabled({ website }) {
    return website.enabled
  },

  basicWebsiteUrl({ data }) {
    return `http://${data.name}.s3-website.${data.region}.amazonaws.com`
  },

  websiteUrl({ website, data }, { basicWebsiteUrl }) {
    if (!website.enabled) {
      return ''
    }

    if (!data.cloudfront) {
      return basicWebsiteUrl
    }

    let url = data.cloudfront

    if (url.indexOf('://') < 0) {
      url = `https://${url}`
    }

    return url
  },

  websiteIndexPage({ website: { config } }) {
    return config.IndexDocument && config.IndexDocument.Suffix
      ? config.IndexDocument.Suffix
      : ''
  },
  websiteErrorPage({ website: { config } }) {
    return config.ErrorDocument && config.ErrorDocument.Key
      ? config.ErrorDocument.Key
      : ''
  },
}

const mutations = {
  SET_WEBSITE_INDEX({ website }, Key) {
    website.config.IndexDocument.Suffix = Key
  },
  SET_WEBSITE_ERROR({ website }, Key) {
    website.config.ErrorDocument.Key = Key
  },
  LOAD_WEBSITE_CONFIG({ website }, data) {
    if (data) {
      for (const k in data) {
        // only load defined
        if (data[k]) {
          website.config[k] = data[k]
        }
      }
    }
  },
  WEBSITE(state, payload) {
    for (const k in payload) {
      state.website[k] = payload[k]
    }
  },
}

const actions = {
  async setWebsiteErrorPage({ commit, state: { bucket, website } }, Key) {
    commit('SET_WEBSITE_ERROR', Key)
    return await bucket.putWebsite(website.config)
  },

  async setWebsiteIndexPage({ commit, state: { bucket, website } }, Key) {
    commit('SET_WEBSITE_INDEX', Key)
    return await bucket.putWebsite(website.config)
  },

  async disableWebsite({ commit, state: { bucket } }) {
    const ok = await bucket.deleteWebsite()

    if (ok) {
      commit('WEBSITE', { enabled: false })
    }
    return ok
  },

  async activeWebsite({
    commit,
    dispatch,
    state: { bucket, website },
    getters: { isBucketPublic },
  }) {
    const ok = await bucket.putWebsite(website.config)
    //
    if (ok) {
      commit('WEBSITE', { enabled: true })

      if (!isBucketPublic) {
        await dispatch('makeBucketPublic')
      }
    }
    return ok
  },

  async getWebsite({ commit, state: { bucket } }) {
    const data = await bucket.getWebsite()

    if (data) {
      commit('WEBSITE', { enabled: true })
      commit('LOAD_WEBSITE_CONFIG', data)
    }

    return data
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
