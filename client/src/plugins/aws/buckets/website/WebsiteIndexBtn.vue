<template>
  <m-tooltip :value="isHome ? 'Is home page' : `Set as website home page`">
    <v-btn icon v-bind="{ loading, color }" @click="setHome">
      <v-icon>mdi-home</v-icon>
    </v-btn>
  </m-tooltip>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  props: {
    itemKey: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
    }
  },

  computed: {
    ...mapGetters({
      websiteIndex: 'awsBuckets/websiteIndexPage',
      website: 'awsBuckets/website',
    }),
    isHome() {
      return this.websiteIndex === this.itemKey
    },
    color() {
      return this.isHome ? 'success' : 'grey'
    },
  },

  methods: {
    ...mapActions({
      setWebsiteIndexPage: 'awsBuckets/setWebsiteIndexPage',
    }),
    async setHome() {
      if (!this.isHome) {
        this.loading = true
        const success = await this.setWebsiteIndexPage(this.itemKey)

        if (success) {
          this.$app.success('Home page set!')
        } else {
          this.$app.error('Unable to set home page')
        }

        this.loading = false
      }
    },
  },
}
</script>
