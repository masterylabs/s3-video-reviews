export default {
  props: {
    useFooter: Boolean,
    footer: {
      type: Object,
      default: null,
    },
  },

  computed: {
    showFooter() {
      return this.useFooter
      // return this.footer && this.footer.text
    },
  },
}
