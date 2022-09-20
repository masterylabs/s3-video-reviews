import Bucket from '../../models/Bucket'

export default {
  //
  async deleteBucketByKey({ rootGetters }, { type, region, Key, id }) {
    if (type === 'full') {
      const bucket = new Bucket(Key, {
        credentials: rootGetters['aws/credentials'],
        region,
      })

      const destroyed = await bucket.forceDestroy()

      if (!destroyed) {
        return false
      }
    }

    const deleted = await this._vm.$app.post(`/buckets/${id}/delete`)

    return deleted && deleted.success
  },
}
