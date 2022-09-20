export default {
  remotePlay() {
    this.play()
  },
  remotePause() {
    this.pause()
  },
  remoteTogglePlay() {
    this.remoteTogglePlay()
  },

  remoteSeek(n) {
    if (n < 0) return
    this.seekTo(n)
  },
  remoteSeekToAndPlay(n) {
    if (n < 0) return
    this.seekToAndPlay(n)
  },

  src(src) {
    this.setState('unstarted')

    this.duration = 0
    this.currentTime = 0

    if (src) {
      this.loadPlayer()
    } else if (this.player && typeof this.player.destroy !== 'undefined') {
      this.player.destroy()
    }
  },

  playerState(v) {
    this.$emit('state', v)
  },
}
