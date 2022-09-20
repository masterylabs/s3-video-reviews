<template>
  <v-btn icon @click="toggle">
    <v-icon v-text="`mdi-fullscreen${active ? '-exit' : ''}`" />
  </v-btn>
</template>

<script>
  export default {
    data() {
      return {
        active: false,
      }
    },

    methods: {
      change() {
        this.active = !this.active

        this.$store.commit('ml/LAYOUT_SET_FULLSCREEN', this.active)
      },

      toggle() {
        if (!this.active) {
          return this.enter()
        }

        this.exit()
      },

      enter() {
        const element = document.querySelector('#app')

        if (element.requestFullscreen) {
          element.requestFullscreen()
        } else if (element.mozRequestFullScreen) {
          element.mozRequestFullScreen()
        } else if (element.webkitRequestFullscreen) {
          element.webkitRequestFullscreen()
        } else if (element.msRequestFullscreen) {
          element.msRequestFullscreen()
        }
      },

      exit() {
        if (document.exitFullscreen) {
          document.exitFullscreen()
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen()
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen()
        }
      },
    },

    beforeDestroy() {
      window.removeEventListener('fullscreenchange', this.change)
    },

    mounted() {
      window.addEventListener('fullscreenchange', this.change)
    },
  }
</script>
