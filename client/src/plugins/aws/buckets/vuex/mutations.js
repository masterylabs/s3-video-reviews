export default {
  SET(state, payload) {
    if (Array.isArray(payload)) {
      const [key, value] = payload
      state[key] = value
    } else {
      for (const k in payload) {
        state[k] = payload[k]
      }
    }
  },

  SET_DATA(state, payload) {
    for (const k in payload) {
      state.data[k] = payload[k]
    }
  },

  SET_META(state, payload) {
    if (!state.data.meta) {
      state.data.meta = {}
    }
    for (const k in payload) {
      state.data.meta[k] = payload[k]
    }
  },

  ADD_FOLDER_META(state, meta) {
    state.data.meta.folders.push(meta)
  },

  REMOVE_FOLDER_META(state, Key) {
    const index = state.data.meta.folders.findIndex((a) => a.Key === Key)
    state.data.meta.folders.splice(index, 1)
  },

  ADD_OBJECT(state, value) {
    const index = state.objects.findIndex(({ Key }) => Key === value.Key)

    // existing overrides remove to update LastModified
    if (index > -1) {
      state.objects.splice(index, 1)
    }

    state.objects.unshift(value)
  },

  SET_OBJECT_PROP(state, [Key, payload]) {
    const index = state.objects.findIndex((a) => a.Key === Key)

    for (const k in payload) {
      state.objects[index][k] = payload[k]
    }
  },

  FOLDER_META_PLACEHOLDER(state, Key) {
    state.data.meta.folders.push({
      Key,
      color: '',
      icon: '',
      displayName: '',
      // placeholder: true,
    })
  },

  REMOVE_OBJECT(state, Key) {
    const index = state.objects.findIndex((item) => item.Key === Key)
    if (index > -1) {
      state.objects.splice(index, 1)
    }
  },

  REMOVE_UPLOAD(state, Key) {
    const index = state.uploads.findIndex((item) => item.Key === Key)
    if (index > -1) {
      state.uploads.splice(index, 1)
    }
  },

  ADD_UPLOAD(state, { file, Key }) {
    state.uploads.push({
      Key,
      file,
      name: file.name,
      loading: false,
      // bucketName: state.bucket.name,
      bucket: state.bucket,
      progress: 0,
    })
  },

  REPLACE_OBJECT(state, { oldKey, newObject }) {
    const item = state.objects.find((obj) => obj.Key === oldKey)
    if (item) {
      for (const k in newObject) {
        item[k] = newObject[k]
      }
    }
  },
}
