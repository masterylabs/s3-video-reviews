// import {mapGetters} from
export default {
  computed: {
    pageUrl() {
      const slug = this.$store.getters['adam/fullSlug']

      let url = this.$store.getters.config.baseurl
      if (this.$store.getters.settings.prefix)
        url += `/${this.$store.getters.settings.prefix}`
      return `${url}/${slug}`
    },
  },
}
