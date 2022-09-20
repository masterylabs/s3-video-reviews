export default {
  methods: {
    clearBgImage() {
      this.$store.commit('layout/SET_PROP', { bgImage: { previewMobi: false } })
    },
    setBgImage(bgImage = {}) {
      this.$store.commit('layout/SET_PROP', { bgImage })
    },
  },
}
