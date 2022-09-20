<template>
  <v-icon v-if="icon" v-text="icon" :color="color" />
</template>

<script>
  export default {
    props: {
      value: {
        type: [String, Boolean, Function],
      },
      color: {
        type: String,
        default: '',
      },
    },

    computed: {
      icon() {
        if (!this.value) return false

        if (typeof this.value == 'string') return this.value
        if (typeof this.value == 'function') return this.value()

        return false
      },
    },
  }
</script>
