<template>
  <v-btn icon @click="$emit('input', !value)">
    <v-icon>mdi-chevron-{{ value ? 'up' : 'down' }}</v-icon>
  </v-btn>
</template>
<script>
export default {
  props: {
    value: Boolean,
  },
}
</script>
