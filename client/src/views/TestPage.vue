<template>
  <div>
    <v-container>
      <adam-media v-if="ready" />
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      ready: 'adam/ready',
      name: 'adam/pageName',
      slug: 'adam/slug',
      endpoint: 'adam/endpoint',
      isChild: 'adam/isChild',
      pageId: 'adam/pageId',

      // test
      // page: 'adam/page',
      // theme: 'adam/theme',
    }),
  },
  async mounted() {
    await this.$store.dispatch('adam/load', 8)
  },
}
</script>
