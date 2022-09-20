import Bucket from '@/plugins/aws/buckets/models/Bucket'
import { getBucketFileName } from '../../helpers'

export default {
  async getBucket({ getters: { bucketAuth, bucketName } }) {
    return new Bucket(bucketName, bucketAuth)
  },

  async saveBucket({
    state: { page },
    dispatch,
    getters: { fileName, slugChanged, savedFileName },
  }) {
    // after locally has been saved
    const { data } = await this._vm.$app.get(`/pages/${page.id}/files/index`)
    const bucket = await dispatch('getBucket')

    const file = new Blob([data.contents], { type: data.type })

    await bucket.uploadObject({
      Key: fileName,
      file,
    })

    if (slugChanged) {
      await bucket.deleteObject(savedFileName)
    }
  },

  async savePageBucket(_, { pageId, bucket, slug }) {
    // fileName, slugChanged, savedFileName
    const Key = getBucketFileName(slug)
    const { data } = await this._vm.$app.get(`/pages/${pageId}/files/index`)

    const file = new Blob([data.contents], { type: data.type })

    const saved = await bucket.uploadObject({
      Key,
      file,
    })

    return saved
  },

  // Bucket Setup

  async setupBucket({ state: { page }, dispatch }) {
    const { data } = await this._vm.$app.get(`/pages/${page.id}/files`)
    const bucket = await dispatch('getBucket')

    const onDone = () => {
      return true
    }

    const next = async () => {
      const item = data.pop()
      const file = new Blob([item.contents], { type: item.type })

      const success = await bucket.uploadObject({
        Key: item.fileName,
        file,
      })

      if (!success) {
        return false
      }

      if (!data.length) {
        return onDone()
      }

      return next()
    }

    return next()
  },
}
