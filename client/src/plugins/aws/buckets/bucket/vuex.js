const baseForm = {
  name: '',
  region: '',
  // name: 'wp-buckets-website',
  // region: 'us-east-1',
  meta: {
    icon: 'bucket',
    color: '',
  },
  is_public: false,
}

const state = {
  addBucket: {
    dialog: false,
    step: 1,
    form: {
      ...baseForm,
      // is_public
    },
  },
}

const getters = {
  addBucket({ addBucket }) {
    return addBucket
  },
}

const mutations = {
  CLEAR_ADD_BUCKET_FORM({ addBucket }) {
    // addBucket.step = 1
    // addBucket.dialog = false
    addBucket.form = {
      ...baseForm,
    }
  },
}

const actions = {
  addBucketClearForm({ commit }) {
    commit('CLEAR_ADD_BUCKET_FORM')
  },
}

export default { state, getters, mutations, actions }
