<template>
  <v-container :fluid="theme.isFluid" class="section-item pa-0">
    <slot />
  </v-container>
</template>

<script>
export default {
  props: {
    theme: {
      type: Object,
      required: true,
    },
  },
}
</script>
