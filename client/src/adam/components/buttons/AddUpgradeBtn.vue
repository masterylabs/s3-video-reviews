<template>
  <v-btn v-bind="{ loading }" color="primary" outlined @click="add">
    <v-icon class="mr-1">mdi-cash-plus</v-icon> Upgrade
  </v-btn>
</template>

<script>
export default {
  props: {
    sectionId: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      loading: false,
    }
  },

  methods: {
    async add() {
      this.loading = true
      await this.$store.dispatch('adam/addSectionUpgrade', this.sectionId)
      //
      this.loading = false
    },
  },
}
</script>
