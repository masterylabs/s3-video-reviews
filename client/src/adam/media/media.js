import {
  isFolder,
  compressImage,
  getBlob,
  isThumb,
} from '@/plugins/aws/buckets/helpers'

import { getTypeDataFromKey } from '@/plugins/aws/buckets/helpers'

const mediaTemplate = {
  dialog: false,
  ready: false,
  loading: false,
  uploading: false,
  path: 'media/',
  data: [],
  targetId: '',
  selectCallbacks: [],
}

const state = {
  media: {
    ...mediaTemplate,
  },
}

const getters = {
  media({ media }) {
    return media
  },

  objectUrlPrefix(_, { bucketName, bucketRegion }) {
    if (bucketRegion === 'us-east-1') {
      return `https://s3.amazonaws.com/${bucketName}/`
    }

    return `https://${bucketName}.s3.${bucketRegion}.amazonaws.com/`
  },

  mediaItems({ media }, { objectUrlPrefix }) {
    const filter = (item) => {
      if (typeof item !== 'object' || !item.Key) {
        return false
      }

      return !isFolder(item.Key) && !isThumb(item.Key)
    }

    const map = (item) => {
      const thumb = media.data.find((thumb) => {
        return (
          typeof thumb === 'object' &&
          thumb.Key &&
          thumb.Key === `${item.Key}__thumb.jpeg`
        )
      })

      // map
      return {
        ...item,
        url: `${objectUrlPrefix}${item.Key}`,
        thumb: thumb ? thumb.Key : '',
        thumbUrl: !thumb ? '' : `${objectUrlPrefix}${thumb.Key}`,
        contentType: getTypeDataFromKey(item.Key).contentType,
      }
    }

    return media.data.filter(filter).map(map)
  },
}

const mutations = {
  MEDIA(state, payload) {
    for (const k in payload) {
      state.media[k] = payload[k]
    }
  },

  MEDIA_ADD_IMAGE(state, image) {
    if (typeof image === 'string') {
      image = {
        Key: image,
      }
    }

    const index = state.media.data.findIndex(({ Key }) => Key === image.Key)

    if (index < 0) {
      state.media.data.push(image)
    }
  },

  MEDIA_REMOVE_IMAGE(state, Key) {
    const index = state.media.data.findIndex((item) => item.Key === Key)
    if (index > -1) {
      state.media.data.splice(index, 1)
    }
  },
  MEDIA_ADD_SELECT_CB(state, cb) {
    state.media.selectCallbacks.push(cb)
  },
}

const actions = {
  clearMedia({ commit }) {
    commit('MEDIA', { ...mediaTemplate })
  },
  // openMedia({commit}, targetId) {
  //   commit
  // },

  onMediaSelect({ commit }, cb) {
    commit('MEDIA_ADD_SELECT_CB', cb)
  },

  callMediaSelect(
    {
      state: {
        media: { selectCallbacks },
      },
    },
    value
  ) {
    selectCallbacks.forEach((cb) => {
      cb(value)
    })
  },

  async openMedia({ state: { media }, commit, dispatch }, targetId) {
    commit('MEDIA', { dialog: true, targetId })
    if (!media.ready && !media.loading) {
      return dispatch('loadMedia')
    }
    return true
  },

  async refreshMedia({ commit, dispatch }) {
    commit('MEDIA', { data: [] })
    return dispatch('loadMedia')
  },

  async loadMedia({ dispatch, commit, state: { media } }) {
    commit('MEDIA', { loading: true })

    const bucket = await dispatch('getBucket')
    const data = await bucket.listObjects({ Prefix: media.path })

    commit('MEDIA', { data, ready: true, loading: false })
  },

  async mediaUpload({ dispatch, commit, state: { media } }, file) {
    commit('MEDIA', { uploading: true })

    // console.log()

    // const regex = /[^0-9a-zA-Z.]/g
    const fileName = file.name
      .replace(/\s+/g, '-')
      .replace(/[^0-9a-zA-Z.-]/g, '')
    // console.log('mu', file.name, fileName)
    const Key = `${media.path}${fileName}`

    // create thumb
    const bucket = await dispatch('getBucket')
    const success = await bucket.uploadObject({ Key, file })

    if (!success) {
      commit('MEDIA', { uploading: false })
      return false
    }

    commit('MEDIA_ADD_IMAGE', { Key, Size: file.size })

    if (file.size <= 15000) {
      commit('MEDIA', { uploading: false })
      return true
    }

    const thumbCreated = await dispatch('createThumb', Key)

    commit('MEDIA', { uploading: false })

    return thumbCreated
  },

  async createThumb({ dispatch, commit }, sourceKey) {
    const bucket = await dispatch('getBucket')
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

    if (uploaded) {
      commit('MEDIA_ADD_IMAGE', { Key: thumbKey, Size: file.size })
    }

    return uploaded
  },

  async deleteMediaItem({ commit, dispatch }, item) {
    const bucket = await dispatch('getBucket')
    const Key = item.Key
    const thumbKey = item.thumb

    commit('MEDIA_REMOVE_IMAGE', Key)
    if (thumbKey) {
      commit('MEDIA_REMOVE_IMAGE', thumbKey)
      await bucket.deleteObject(thumbKey)
    }

    await bucket.deleteObject(Key)
  },

  async processMediaItems({ dispatch }, items) {
    for (const k in items) {
      // validate

      if (typeof items[k] !== 'object') {
        continue
      }

      const item = items[k]

      const isHidden = item.name.charAt(0) === '.'

      // skip hidden files

      if (isHidden) {
        continue
      }

      // que upload
      dispatch('mediaUpload', item)
    }
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
