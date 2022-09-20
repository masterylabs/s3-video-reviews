export default {
  namespaced: true,
  state: {
    bgImage: {
      // show: false,
      previewMobi: false,
      mobiLandscape: false,
      src: '',
      mobiSrc: '',
      filter: '',
      opacity: 1,
    },
  },

  getters: {
    bgImage({ bgImage }) {
      return bgImage
    },
  },

  mutations: {
    SET_PROP(state, payload) {
      for (const k in payload) {
        state[k] = payload[k]
      }
    },
  },
}
