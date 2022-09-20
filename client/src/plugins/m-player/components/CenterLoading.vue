<template>
  <m-player-layer :max-height="maxHeight">
    <v-progress-circular
      size="100"
      width="7"
      :color="color || 'rgba(255,255,255,0.5)'"
      indeterminate
    ></v-progress-circular>
  </m-player-layer>
</template>

<script>
export default {
  props: {
    color: {
      type: String,
      default: '',
    },
    maxHeight: {
      type: [String, Number],
      default: null,
    },
  },
}
</script>
