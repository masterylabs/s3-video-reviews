export default {
  play() {
    this.player.play()
  },

  pause() {
    this.player.pause()
  },

  seekTo(n) {
    this.player.time(n)
  },

  playFromStart() {
    const n = this.root.getStart()
    this.player.time(n)
    this.player.play()
  },

  destroy() {
    if (this.player) this.player.destroy()
  },
}
