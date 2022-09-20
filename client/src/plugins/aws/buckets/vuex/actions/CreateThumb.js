import { compressImage, getBlob } from '../../helpers'

export default {
  async createThumb({ commit, state }, payload) {
    // bucket

    const bucket =
      typeof payload === 'object' && payload.bucket
        ? payload.bucket
        : state.bucket

    // source key

    const sourceKey = typeof payload === 'object' ? payload.Key : payload

    // get this from bucket!!
    const url = await bucket.getDownloadUrl(sourceKey)

    const blob = await getBlob(url)

    const thumbKey = sourceKey + '__thumb.jpeg'
    const fileName = thumbKey.split('/').pop()

    // create file
    const file = new File([blob], fileName, { type: 'image/jpeg' })

    const thumb = await compressImage(file, {
      quality: 0.8,
      maxWidth: 275,
      maxHeight: 200,
    })

    // upload image
    const uploaded = await bucket.uploadObject({
      file: thumb,
      Key: thumbKey,
    })

    // If same bucket, add to file
    const sameBucket =
      state.bucket && state.bucket.name === bucket.name ? true : false

    //   return uploaded
    if (sameBucket) {
      const newObject = await bucket.getObjectListFormat(thumbKey)

      if (newObject) {
        commit('ADD_OBJECT', newObject)
      }
    }

    return uploaded
  },
}
