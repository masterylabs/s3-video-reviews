export default {
  data() {
    return {
      onMutedNoticeBtn: {
        click: this.toggleMute,
      },
    }
  },

  computed: {
    showMutedNoticeBtn() {
      return this.isMuted && ['play', 'playing'].includes(this.playerState)
    },

    mutedNoticeBtnAttrs() {
      return {
        btn: {
          xLarge: true,
          color: this.color,
          dark: this.isDark,
          fab: true,
        },
      }
    },
  },
}
