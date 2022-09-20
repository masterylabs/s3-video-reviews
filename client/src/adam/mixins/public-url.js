export default {
  computed: {
    publicUrl() {
      if (typeof this.$public_url === 'string') {
        return this.$public_url
      }

      if (typeof this.$store === 'object') {
        return this.$store.getters.config.public_url
      }

      // live
      //   else if (window._DATA && window._DATA.url) {
      //     return window._DATA.url
      //   }
      else if (this.$app.config && this.$app.config.public) {
        return this.$app.config.public
      }

      return ''
      //   return this.$app.config.url || this.$app.config.public
    },
  },
}
