<template>
  <v-sheet :dark="theme.dark" class="pa-16">
    <slot />
  </v-sheet>
</template>

<script>
  export default {
    computed: {
      theme() {
        return this.$store.getters['adam/theme']
      },
    },
  }
</script>
