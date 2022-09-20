import { PutObjectCommand } from '@aws-sdk/client-s3'
import { getSignedUrl } from '@aws-sdk/s3-request-presigner'
import axios from 'axios'
import { getUniqueKey } from '../../helpers'

const getFileKey = (file, path = '') => {
  let Key = path
  if (file._dirPath) {
    Key += file._dirPath
  }

  Key += file.name

  if (file._isDir) {
    Key += '/'
  }

  return Key
}

export default {
  queUploads({ dispatch }, files) {
    files.forEach((file) => {
      dispatch('queUpload', file)
    })
  },

  async queUpload(
    {
      commit,
      dispatch,
      state: { overwrite, path, objects },
      getters: { activeUploadsCount },
    },
    file
  ) {
    // rename if not override
    // let Key = path + file.name
    let Key = getFileKey(file, path)

    // return

    if (!overwrite && !file._isDir) {
      const Keys = objects.map((item) => item.Key)
      Key = getUniqueKey(Key, Keys)
    }

    commit('ADD_UPLOAD', { file, Key })

    if (!activeUploadsCount) {
      dispatch('upload')
    }

    setTimeout(() => {
      window.scrollTo(0, document.body.scrollHeight)
    }, 200)
  },

  async upload({
    commit,
    dispatch,
    state: { uploads, bucket },
    // rootGetters: { settings },
  }) {
    // single upload

    const onUploaded = async (item) => {
      //
      //   auto: settings.auto_thumbs,
      //   isImage: isImage(item.Key),
      //   smallEnough: item.Size >= 15000,
      // })
      // if (settings.auto_thumbs && isImage(item.Key) && item.Size >= 15000) {
      //
      //   const thumbCreated = await dispatch('createThumb', item)
      //
      // }
      const sameBucket = bucket.name === item.bucket.name

      //

      if (sameBucket) {
        try {
          const obj = await item.bucket.getObjectListFormat(item.Key)
          commit('ADD_OBJECT', obj)
        } catch (e) {
          return false
        }
      }

      return nextItem()
    }

    const nextItem = async () => {
      const item = uploads.find((item) => !item.loading && !item.progress)

      if (!item) {
        return true
      }

      item.loading = true
      if (item.file._isDir) {
        item.loading = true
        // await item.bucket.createFolder(item.Key)
        await dispatch('createFolder', { Key: item.Key, bg: true })
        item.progress = 100
        item.loading = false
        // need to change
        return onUploaded(item)
      }

      //

      const args = {
        Bucket: item.bucket.name,
        Key: item.Key,
      }

      const url = await getSignedUrl(
        item.bucket.s3Client,
        new PutObjectCommand(args),
        {
          expiresIn: 86400,
        }
      )

      const onUploadProgress = function (e) {
        let value = Math.round((e.loaded * 100) / e.total)
        item.progress = value
      }

      const headers = {
        'Content-type': item.file.type,
      }

      try {
        await axios.put(url, item.file, { headers, onUploadProgress })
        item.loading = false
        return onUploaded(item)
      } catch (err) {
        item.loading = false
        return false
      }
    }

    // may not be necessary
    return nextItem()
  },

  // added v1.0.2

  getUniqueObjectKey({ state: { path, objects } }, Key) {
    // check if key has path
    if (path && Key.indexOf('/') < 0) {
      Key = path + Key
    }

    return getUniqueKey(
      Key,
      objects.map((item) => item.Key)
    )
  },
}
