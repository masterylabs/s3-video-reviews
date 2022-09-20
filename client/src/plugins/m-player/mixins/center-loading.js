export default {
  computed: {
    showCenterLoading() {
      if (this.remoteLoading) return true

      return ['unstarted', 'buffering', 'seeking'].includes(this.playerState)
    },

    centerLoadingAttrs() {
      return {
        maxHeight: this.maxHeight,
        color: this.color,
      }
    },
  },
}
