<template>
  <v-switch
    v-model="model"
    v-bind="{ loading }"
    hide-details
    :color="model && isBucketPublic ? 'success' : 'error'"
    class="mt-0 mx-4"
    label="Website"
    v-on="{ change }"
  ></v-switch>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      model: false,
      loading: false,
    }
  },

  computed: {
    ...mapGetters({
      isBucketPublic: 'awsBuckets/isBucketPublic',
    }),
  },

  methods: {
    ...mapActions({
      getWebsite: 'awsBuckets/getWebsite',
      activeWebsite: 'awsBuckets/activeWebsite',
      disableWebsite: 'awsBuckets/disableWebsite',
    }),
    async change(value) {
      this.loading = true

      if (value) {
        if (!(await this.activeWebsite())) {
          this.$app.error('Unable To activate')
          this.model = false
        }
      } else {
        if (!(await this.disableWebsite())) {
          this.$app.error('Unable To de-activate')
          this.model = true
        }
      }

      this.loading = false
    },
  },

  async created() {
    this.loading = true
    const website = await this.getWebsite()

    this.model = !!website
    this.loading = false
  },
}
</script>
