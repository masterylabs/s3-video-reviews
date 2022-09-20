<template>
  <v-slider
    v-bind="{ value, hideDetails }"
    label="Elevation"
    max="16"
    @input="$emit('input', $event)"
  >
    <template v-slot:append>
      <span class="primary--text mt-1">{{ value }}</span>
    </template>
  </v-slider>
</template>

<script>
  export default {
    props: {
      hideDetails: Boolean,
      value: {
        type: Number,
      },
    },
  }
</script>
