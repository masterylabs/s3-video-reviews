export default {
  computed: {
    showPoster() {
      if (!this.poster) return false

      if (this.isPreview && this.playerState !== 'unstarted') {
        return false
      }

      return ['unstarted', 'ready', 'ended'].includes(this.playerState)
    },
  },
}
