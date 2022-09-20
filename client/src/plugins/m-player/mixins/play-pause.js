export default {
  data() {
    return {
      onPlayPause: {
        click: this.togglePlay,
      },
    }
  },

  computed: {
    showPlayPause() {
      return !this.noPause //  || this.canPlay
    },
    playPauseAttrs() {
      const dark = this.isDark

      return {
        playerState: this.playerState,
        btn: {
          ...this.config.btn,
          height: this.controlsHeight,
          color: this.getColor,
          dark,
          light: !dark,
          loading: !this.playerReady,
        },
        icon: {
          ...this.config.icon,
          icon: this.canPause
            ? 'mdi-pause'
            : this.playerReady
            ? 'mdi-play'
            : '',
        },
      }
    },
  },
}
