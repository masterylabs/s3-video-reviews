export default {
  props: {
    width: {
      type: Number,
      default: null,
    },
    maxWidth: {
      type: Number,
      default: null,
    },
    height: {
      type: Number,
      default: null,
    },
    maxHeight: {
      type: Number,
      default: null,
    },
  },

  computed: {
    widthHeight() {
      return {
        width: this.width,
        height: this.height,
        maxWidth: this.maxWidth,
        maxHeight: this.maxHeight,
      }
    },
  },
}
