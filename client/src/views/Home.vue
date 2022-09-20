<template>
  <div class="pt-5">
    <v-container>
      <adam-pages v-on="{ select }" title="Offers">
        <template v-slot:no-results>
          <div class="text-center pa-4">You do not have any offers</div>
        </template>
      </adam-pages>
    </v-container>
  </div>
</template>

<script>
export default {
  methods: {
    select(id) {
      this.$router.push({ name: 'offer', params: { id } })
    },
  },

  beforeDestroy() {
    this.$store.commit('SEARCH', { total: 0 })
  },
}
</script>
