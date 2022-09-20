<template>
  <v-icon
    class="mr-2"
    style="margin-top:-2px"
    :color="value ? 'primary' : ''"
    @click="$emit('input', !value)"
    v-text="`mdi-chevron-${value ? 'up' : 'down'}`"
  >
    mdi-menu
  </v-icon>
</template>

<script>
  export default {
    props: {
      value: Boolean,
    },
  }
</script>
