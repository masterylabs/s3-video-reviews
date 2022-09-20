export default {
  play() {
    this.player.playVideo()
  },

  pause() {
    this.player.pauseVideo()
  },

  seekTo(n) {
    if (['ready', 'ended', 'paused'].includes(this.root.playerState)) {
      this.on['playing'] = () => {
        this.root.pause()
      }
    }

    this.player.seekTo(n)
    this.root.setCurrentTime(n)
  },

  playFromStart() {
    const n = this.root.getStart()
    this.player.seekTo(n).then(() => {
      this.root.play()
    })
  },

  seekToAndPlay(n) {
    this.player.seekTo(n).then(() => {
      this.root.play()
    })
  },

  unmute() {
    this.player.unMute()
    this.root.setMuted(false)
  },

  mute() {
    this.player.mute()
    this.root.setMuted(true)
  },

  onVideoChange() {
    this.player.loadVideoById({
      videoId: this.root.src,
      startSeconds: 0,
      // 'endSeconds': 60
    })
  },

  destroy() {
    if (this.player) this.player.destroy()
  },
}
