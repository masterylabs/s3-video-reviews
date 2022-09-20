export default {
  play() {
    this.player.play()
  },
  pause() {
    this.player.pause()
  },
  seekTo(n) {
    this.player.setCurrentTime(n)
    this.root.setCurrentTime(n)
  },

  playFromStart() {
    const n = this.root.getStart()

    this.player.setCurrentTime(n).then(() => {
      this.player.play()
    })
  },

  seekToAndPlay(n) {
    this.player.setCurrentTime(n).then(() => {
      this.player.play()
    })
  },

  mute() {
    this.player.setVolume(0).then(() => {
      this.root.setMuted(true)
    })
  },

  unmute() {
    this.player.setVolume(1).then(() => {
      this.root.setMuted(false)
    })
  },

  destroy() {
    if (this.player) this.player.destroy()
  },
}
