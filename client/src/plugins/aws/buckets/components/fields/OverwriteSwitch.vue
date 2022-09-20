<template>
  <v-switch
    v-model="overwrite"
    color="error"
    label="Overwrite"
    class="mt-0"
    hide-details
  ></v-switch>
</template>

<script>
export default {
  computed: {
    overwrite: {
      get() {
        return this.$store.state.awsBuckets.overwrite
      },
      set(overwrite) {
        this.$store.commit('awsBuckets/SET', { overwrite })
      },
    },
  },
}
</script>
