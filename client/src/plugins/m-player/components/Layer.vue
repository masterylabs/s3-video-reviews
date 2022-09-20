<template>
  <div
    class="m-player-layer"
    :class="getClass"
    :style="maxHeight ? `max-height:${maxHeight}px` : ''"
  >
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    maxHeight: {
      type: [String, Number],
      default: null,
    },
    align: {
      type: String,
      default: '',
    },
    dark: Boolean,
  },

  computed: {
    getClass() {
      const list = []

      if (this.align) list.push(`m-player-flex-end`)

      if (this.dark) list.push('m-player-layer-dark')

      return list
    },
  },
}
</script>
