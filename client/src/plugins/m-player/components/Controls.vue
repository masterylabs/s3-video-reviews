<template>
  <div
    :style="`width:100%;height:${height}px`"
    class="m-player-row ml-yellow"
    @mouseenter="$emit('mouseenter')"
    @mouseleave="$emit('mouseleave')"
  >
    <slot name="start" />
    <slot name="center" />
    <slot name="end" />
  </div>
  <!-- </m-player-layer> -->
</template>

<script>
export default {
  props: {
    height: {
      type: [Number, String],
      default: 55,
    },
    color: {
      type: String,
      default: '',
    },
    dark: Boolean,
  },

  computed: {
    attrs() {
      return {
        dark: this.dark,
        light: this.light,
      }
    },
  },
}
</script>
