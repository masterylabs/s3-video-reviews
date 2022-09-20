export default {
  play() {
    this.video.play()
  },
  pause() {
    this.video.pause()
  },
  seekTo(n) {
    this.video.currentTime = n
    this.onTimeUpdate()
  },

  seekToAndPlay(n) {
    this.playOnSeeked = true
    this.video.currentTime = n
  },

  playFromStart() {
   
    const start = this.root.getStart()
    this.playOnSeeked = true

    this.video.currentTime = start
  },

  mute() {
    this.video.muted = 1
    this.root.setMuted(true)
  },

  unmute() {
    this.video.muted = 0
    this.root.setMuted(false)
  },

  destroy() {
    this.video.pause()
    this.video.removeAttribute('src')
  },
}
