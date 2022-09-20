<template>
  <m-tooltip value="Refresh">
    <v-btn icon v-bind="{ loading }" v-on="{ click }" class="mr-2">
      <v-icon>mdi-reload</v-icon>
    </v-btn>
  </m-tooltip>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      loading: false,
    }
  },
  methods: {
    ...mapActions({
      refreshFiles: 'awsBuckets/refreshFiles',
    }),
    async click() {
      this.loading = true
      await this.refreshFiles()

      this.loading = false
    },
  },
}
</script>
