export default {
  data() {
    return {
      onVolume: {
        click: this.toggleMute,
      },
    }
  },

  computed: {
    showVolume() {
      return !this.noAudioBtn
    },

    volumeAttrs() {
      const dark = this.isDark
      const icon = this.isMuted ? 'mdi-volume-off' : 'mdi-volume-high'
      return {
        btn: {
          ...this.config.btn,
          height: this.controlsHeight,
          color: this.getColor,
          dark,
          light: !dark,
        },
        icon: {
          ...this.config.icon,
          icon,
        },
      }
    },
  },
}
