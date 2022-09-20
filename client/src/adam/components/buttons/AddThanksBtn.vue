<template>
  <v-btn v-bind="{ loading }" v-on="{ click }" depressed>
    <v-icon class="mr-1">mdi-plus</v-icon> Thanks Page
  </v-btn>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
    }
  },

  methods: {
    async click() {
      this.loading = true

      await this.$store.dispatch('adam/addThanks')

      this.loading = false
    },
  },
}
</script>
