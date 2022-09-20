<template>
  <m-tooltip
    :value="
      isError ? 'Is error page' : `Set as website error (404 not found) page`
    "
  >
    <v-btn icon v-bind="{ loading, color }" @click="setHome">
      <v-icon>mdi-alert-circle-outline</v-icon>
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
      websiteError: 'awsBuckets/websiteErrorPage',
    }),
    isError() {
      return this.websiteError === this.itemKey
    },
    color() {
      return this.isError ? 'error' : 'grey'
    },
  },

  methods: {
    ...mapActions({
      setWebsiteErrorPage: 'awsBuckets/setWebsiteErrorPage',
    }),
    async setHome() {
      if (!this.isError) {
        this.loading = true
        const success = await this.setWebsiteErrorPage(this.itemKey)

        if (success) {
          this.$app.success('Error page set!')
        } else {
          this.$app.error('Unable to set error page')
        }

        this.loading = false
      }
    },
  },
}
</script>
