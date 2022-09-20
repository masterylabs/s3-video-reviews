import { GetObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
import axios from 'axios'

export default {
  async downloadFile({ dispatch, getters: { files } }, Key) {
    const file = files.find((a) => a.Key === Key)

    const url = await dispatch('getDownloadUrl', Key)
    if (!url) {
      return false
    }
    try {
      const { data } = await axios({ url, method: 'GET', responseType: 'blob' })
      const url2 = window.URL.createObjectURL(new Blob([data]))
      const link = document.createElement('a')
      link.href = url2
      link.download = file.name
      link.setAttribute('download', file.name) //or any other extension
      document.body.appendChild(link)
      link.click()
      setTimeout(() => {
        document.body.removeChild(link)
      }, 100)
      return true
    } catch {
      return false
    }
  },

  async getDownloadUrl({ state: { bucket } }, Key) {
    const client = bucket.s3Client

    const params = {
      Key,
      Bucket: bucket.name,
    }
    const commandA = new GetObjectCommand(params)

    return await getSignedUrl(client, commandA, { expiresIn: 3600 })
  },
}
