export default {
  props: {
    //
  },

  data() {
    return {
      onTimeline: {
        seekTo: this.seekTo,
      },
    }
  },

  computed: {
    timelineAttrs() {
      return {
        color: this.getColor,
        dark: this.isDark,
        duration: this.duration,
        currentTime: this.currentTime,
        height: this.controlsHeight,
        start: this.start,
        end: this.end,
        playerState: this.playerState,
      }
    },
  },
}
