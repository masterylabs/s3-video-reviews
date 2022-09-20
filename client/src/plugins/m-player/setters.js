export default {
  setReady(n) {
    this.duration = n
    this.playerReady = true
    this.setState('ready')

    this.mobileDebug = `ready ${this.$isMobile}`

    if (this.$isMobile) this.onMobileReady()

    this.onReady()
  },

  setState(state) {
    if (state === this.playerState) return

    if (this.playerState === 'ended' && ['pause', 'paused'].includes(state)) {
      return
    }

    if (state === this.playerState) return

    this.callOnEvent(state)

    this.playerState = state
  },

  setEnded() {
    if (this.loop || this.isPreview) return this.playFromStart()
    else {
      this.playerState = 'ended'
      this.$emit('ended')
    }
  },

  setCurrentTime(n) {
    // Emit currentTime
    if (this.emitCurrentTime) {
      const rounded = Math.floor(n)
      if (rounded !== this.lastEmittedCurrentTime) {
        this.lastEmittedCurrentTime = rounded
        this.$emit('current-time', rounded)
      }
    }

    const end = this.getEnd()

    if (end && end <= n) {
      this.pause()
      return this.setEnded()
    }
    this.currentTime = n
  },

  setMuted(v) {
    this.isMuted = v
  },
}
