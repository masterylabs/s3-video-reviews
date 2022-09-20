<template>
  <div>
    <v-icon
      class="mr-1 mt-n1"
      v-text="icon"
      :color="complete ? 'success' : active ? 'primary' : 'grey'"
    />
    <span class="body-1">
      <slot />
    </span>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Number,
      required: true,
    },
    index: {
      type: Number,
      required: true,
    },
  },

  computed: {
    active() {
      return this.value === this.index
    },
    complete() {
      return this.value > this.index
    },
    icon() {
      if (this.complete) {
        return 'mdi-check-circle'
      }
      return `mdi-numeric-${this.index + 1}-circle`
    },
  },
}
</script>
