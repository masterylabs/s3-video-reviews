<template>
  <v-btn icon :absolute="absolute" left top @click="toggle">
    <v-icon v-text="`mdi-chevron-${active ? 'right' : 'left'}`" />
  </v-btn>
</template>

<script>
export default {
  props: {
    usePost: Boolean,
    absolute: Boolean,
  },

  data() {
    return {
      active: false,
    }
  },

  methods: {
    toggle() {
      this.active = !this.active

      if (this.usePost) {
        if (this.active) window.parent.postMessage('ml_expand', '*')
        else window.parent.postMessage('ml_collapse', '*')
        return
      }

      const el = document.querySelector('body')
      if (this.active) el.classList.add('ml-expanded')
      else el.classList.remove('ml-expanded')
    },
  },
}
</script>
