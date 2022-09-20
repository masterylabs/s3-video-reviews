export default {
  async getBucketStatus({ dispatch, commit }) {
    await dispatch('getBucketPublicAccess')
    await dispatch('getBucketPolicy')
    commit('SET', { bucketStatusReady: true })
  },

  async makeBucketPublic({ dispatch }) {
    const a = await dispatch('setBucketPublicAccess')
    const b = await dispatch('putBucketPolicy')

    return a && b ? true : false
  },

  async makeBucketPrivate({ dispatch }) {
    const a = await dispatch('deleteBucketPublicAccess')
    const b = await dispatch('deleteBucketPolicy')

    return a && b ? true : false
  },

  async getBucketPublicAccess({ state: { bucket }, commit }) {
    const bucketPublicAccess = await bucket.getPublicAccess()

    commit('SET', { bucketPublicAccess })
    return bucketPublicAccess
  },

  async deleteBucketPublicAccess({ dispatch }) {
    const value = {
      BlockPublicAcls: true,
      IgnorePublicAcls: true,
      BlockPublicPolicy: true,
      RestrictPublicBuckets: true,
    }

    return dispatch('putBucketPublicAccess', value)
  },

  setBucketPublicAccess({ dispatch }) {
    const value = {
      BlockPublicAcls: false, // true,
      IgnorePublicAcls: false, // true,
      BlockPublicPolicy: false,
      RestrictPublicBuckets: false,
    }
    return dispatch('putBucketPublicAccess', value)
  },

  async putBucketPublicAccess({ state: { bucket }, commit }, value) {
    const success = await bucket.putPublicAccess(value)

    if (success) {
      commit('SET', { bucketPublicAccess: value })
      return value
    }

    return false
  },
  //
  async getBucketPolicy({ state: { bucket }, commit }) {
    const policy = await bucket.getPolicy()

    if (policy) {
      commit('SET', { bucketPolicy: policy })
    }

    return policy
  },

  async deleteBucketPolicy({ state: { bucket }, commit }) {
    const success = await bucket.deletePolicy()

    if (success) {
      commit('SET', { bucketPolicy: null })
    }
    return success
  },

  async putBucketPolicy({ state: { bucket }, commit }) {
    const policy = {
      Version: '2008-10-17',
      Statement: [
        {
          Sid: 'AllowPublicRead',
          Effect: 'Allow',
          Principal: {
            AWS: '*',
          },
          Action: 's3:GetObject',
          Resource: `arn:aws:s3:::${bucket.name}/*`,
          //   Resource: 'arn:aws:s3:::wp-bucket-test-3/image-one.png',
        },
      ],
    }

    const success = await bucket.putPolicy(policy)

    if (success) {
      commit('SET', { bucketPolicy: policy })
      return policy
    }
    return false
  },
}
