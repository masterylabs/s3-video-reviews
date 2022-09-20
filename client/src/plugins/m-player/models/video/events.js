export default {
  onReady() {
    const start = this.root.getStart()

    if (start) {
      this.video.currentTime = start
    } else {
      this.root.setReady(this.video.duration)
    }
  },
  onSeeked() {
    if (this.playOnSeeked) {
      this.playOnSeeked = false
      return this.play()
    }

    if (!this.root.playerReady) return this.root.setReady(this.video.duration)
    else this.root.setState('seeked')
  },
  onEnded() {
    if (this.root.getLoop()) this.playFromStart()
    else this.root.setEnded()
  },

  onPause() {
    const end = this.root.getEnd()
    // html5 video will fire pause on ended
    const hasEnded =
      (end && this.video.currentTime >= end) ||
      this.video.currentTime === this.video.duration

    if (hasEnded) return

    this.root.setState('pause')
  },

  onTimeUpdate() {
    // silent loop for video with set end time
    const end = this.root.getEnd()

    if (end) {
      if (
        (end && this.video.currentTime >= end) ||
        this.video.currentTime === this.video.duration
      ) {
        this.video.pause()
        return this.onEnded()
      }
    }

    this.root.setCurrentTime(this.video.currentTime)
  },

  onVideoChange() {
    // start new player
    this.video.autoplay = this.root.isAutoplay
    this.video.muted = this.root.isMuted
    this.video.src = this.root.src
  },
}
