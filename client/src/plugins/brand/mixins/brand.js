import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      settings: 'brand/settings',
    }),
  },
  methods: {
    setBrand() {
      const app = {
        name: this.settings.name,
        label: this.settings.label,
        logo: this.settings.logo,
        logo_link: this.settings.logo_link,
      }

      this.$store.commit('SET', { app })
    },

    unsetBrand() {
      const _app = this.$store.state.brand.unbraded.app

      const app = {
        name: _app.name || '',
        label: _app.label || '',
        logo: _app.logo || '',
        logo_link: _app.logo_link || '',
      }

      // this.$app
      this.$store.commit('SET', { app })
    },
  },
}
