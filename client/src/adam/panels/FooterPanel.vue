<template>
  <v-expansion-panel>
    <adam-panel-header :disabled="footer.disabled">
      {{ footer.name || footer.type }}
    </adam-panel-header>
    <v-expansion-panel-content>
      <adam-footer-form :id="footer.id" />
    </v-expansion-panel-content>
  </v-expansion-panel>
</template>

<script>
export default {
  computed: {
    footer() {
      return this.$store.getters['adam/footer']
    },
  },
}
</script>
