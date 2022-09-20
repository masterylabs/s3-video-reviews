export default {
  data() {
    return {
      onCenterPlay: {
        click: this.useTogglePlay,
      },
    }
  },

  computed: {
    showCenterPlay() {
      if (this.noCenterPlay) return false

      if (this.showCenterLoading) return false // covers remoteLoading

      if (this.playerState === 'ended' && this.noReplay) return false

      if (this.isPreview && this.playerState !== 'unstarted')
        return !this.noCenterPlayInPreview
      return this.canPlay
    },
    centerPlayAttrs() {
      const dark = this.isDark

      return {
        loading: true,
        playerState: this.playerState,
        maxHeight: this.maxHeight,
        rounded: this.rounded,
        btn: {
          ...this.config.btn,
          xLarge: true,
          color: this.getColor,
          dark,
          light: !dark,
        },
        icon: {
          ...this.config.icon,
          icon: this.playerState === 'ended' ? 'mdi-replay' : 'mdi-play',
        },
      }
    },
  },
}
