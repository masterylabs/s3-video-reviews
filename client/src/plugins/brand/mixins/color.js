// import { mapGetters } from 'vuex'
import { colors } from '@/config'
export default {
  data() {
    return {
      colorMap: {
        primary_color: 'primary',
        secondary_color: 'secondary',
        accent_color: 'accent',
      },
    }
  },

  // computed: {
  //   ...mapGetters({
  //     settings: 'brand/settings',
  //   }),
  // },

  methods: {
    setColors(config = null) {
      if (!config) {
        config = this.$store.getters['brand/settings'] // this.settings
      }
      for (const k in this.colorMap) {
        if (config[k]) {
          this.setColor(this.colorMap[k], config[k])
        }
      }
    },

    unsetColors() {
      for (const k in colors) {
        this.setColor(k, colors[k])
      }
    },

    setColor(key, value) {
      this.$vuetify.theme.themes.dark[key] = value
      this.$vuetify.theme.themes.light[key] = value
    },
  },
}
