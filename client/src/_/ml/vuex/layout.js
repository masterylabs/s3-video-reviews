export default {
  state: {
    layout: {
      inFullscreen: false,
      drawer: true,
      settings: {
        drawer: false,
        view: '',
      },
    },
  },
  getters: {
    layout({ layout }) {
      return layout
    },
  },
  mutations: {
    LAYOUT_SET_FULLSCREEN(state, value) {
      state.layout.inFullscreen = value
    },
  },
}
