// import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
import { S3Client, ListObjectsCommand } from '@aws-sdk/client-s3'
import axios from 'axios'

axios.defaults.headers.post['Content-Type'] =
  'application/x-www-form-urlencoded'
axios.defaults.headers.post['Accept'] = 'application/json'

// ...

export default {
  // returns bucket or false
  async getBucket({ getters: { auth } }, name) {
    const s3Client = new S3Client(auth)

    try {
      return await s3Client.send(new ListObjectsCommand({ Bucket: name }))
    } catch (err) {
      this._vm.$app.error(err)
      return false
    }
  },

  async getBuckets({ getters: { auth } }) {
    const Bucket = 'wp-buckets-bucket'
    const s3Client = new S3Client(auth)

    try {
      await s3Client.send(new ListObjectsCommand({ Bucket }))
    } catch (err) {
      return false
    }
  },
}
