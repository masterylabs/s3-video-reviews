export default {
  props: {
    container: {
      type: Object,
      default() {
        return {}
      },
    },
  },

  computed: {
    containerAttrs() {
      return {
        // height: this.height,
        width: this.width,
      }
    },
  },
}
