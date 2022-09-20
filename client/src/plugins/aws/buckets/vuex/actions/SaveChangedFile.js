import { PutObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
import axios from 'axios'

export default {
  async saveChangedFile({ dispatch, commit, state: { bucket } }, payload) {
    const { newFile, oldItem } = payload
    const keepOriginal = payload.keep
    const newKey = await dispatch('getUniqueObjectKey', newFile.name)

    const args = {
      Bucket: bucket.name,
      Key: newKey,
    }

    const url = await getSignedUrl(
      bucket.s3Client,
      new PutObjectCommand(args),
      {
        expiresIn: 86400,
      }
    )

    const headers = {
      'Content-type': newFile.type,
    }

    try {
      await axios.put(url, newFile, { headers })
    } catch (err) {
      return false
    }

    // await delete old file
    const newObject = await bucket.getObjectListFormat(newKey)

    if (keepOriginal) {
      commit('ADD_OBJECT', newObject)
    } else {
      // delete old one
      await bucket.deleteObject(oldItem.Key)

      // replace
      newObject.tableKey = oldItem.Key
      commit('REPLACE_OBJECT', { oldKey: oldItem.Key, newObject })
    }
    return true
  },
}
