<template>
  <v-container v-if="brand.ready">
    <v-sheet max-width="700">
      <brand-toolbar class="mb-3" />
      <v-row>
        <v-col>
          <brand-form />
        </v-col>
        <v-col class="shrink">
          <brand-colors />
        </v-col>
      </v-row>
    </v-sheet>
  </v-container>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState({
      brand: 'brand',
    }),
  },

  async created() {
    this.$store.dispatch('loading')
    if (!this.ready) await this.$store.dispatch('brand/load')

    this.$store.dispatch('loading', false)
  },
}
</script>
