export default {
  props: {
    noGutters: Boolean,
    align: {
      type: String,
      default: '',
    },
    justify: {
      type: String,
      default: '',
    },
  },

  computed: {
    row() {
      const value = {}
      for (const k in this.$props) {
        if (this.$props[k]) {
          value[k] = this.$props[k]
        }
      }

      return value
    },
  },
}
