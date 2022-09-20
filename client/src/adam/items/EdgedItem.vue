<template>
  <div :class="classList">
    <slot />
  </div>
</template>

<script>
import { isFirstEl, isLastEl } from '../helpers/dom'
export default {
  props: {
    value: Boolean,
    theme: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      isMounted: false,
    }
  },

  computed: {
    isFirst() {
      return this.isMounted ? isFirstEl(this.$el) : false
    },
    isLast() {
      return this.isMounted ? isFirstEl(this.$el) : false
    },

    classList() {
      if (!this.value) {
        return []
      }
      const value = []

      const margin = {
        t: 0,
        b: 0,
        x: 0,
      }

      if (this.theme.blockPadding) {
        margin.t = this.theme.blockPadding
        margin.b = this.theme.blockPadding
        margin.x = this.theme.blockPadding
      }

      if (this.theme.boxPaddingY) {
        margin.t += this.theme.boxPaddingY
        margin.b += this.theme.boxPaddingY
        // margin.x += this.theme.boxPaddingY
      }

      if (this.theme.pa) {
        margin.x += this.theme.pa
        if (this.isFirst) {
          margin.t += this.theme.pa
        }
        if (this.isLast) {
          margin.b += this.theme.pa
        }
      }

      for (const k in margin) {
        if (margin[k]) {
          value.push(`m${k}-n${margin[k]}`)
        }
      }

      return value
    },
  },

  mounted() {
    this.isMounted = true
  },
}
</script>
