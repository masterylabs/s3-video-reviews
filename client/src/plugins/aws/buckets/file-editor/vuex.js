import { PutObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
import axios from 'axios'

const actions = {
  async getFileContents({ state: { bucket } }, Key) {
    return await bucket.getObjectBody(Key)
  },

  /// PUT FILE

  async putFileContents({ state: { bucket } }, item) {
    const args = {
      Bucket: bucket.name,
      Key: item.Key,
    }

    const command = new PutObjectCommand(args)
    const url = await getSignedUrl(bucket.s3Client, command, {
      expiresIn: 86400,
    })

    const headers = {
      'Content-type': item.contentType,
    }

    try {
      await axios.put(url, item.contents, { headers })
      return true
    } catch (err) {
      return false
    }
  },
}

export default {
  actions,
}
