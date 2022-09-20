export default {
  async onTicker() {
    if (this.gettingCurrentTime) return

    this.gettingCurrentTime = true

    const n = await this.player.getCurrentTime()

    this.root.setCurrentTime(n)

    this.gettingCurrentTime = false

    const end = this.root.getEnd()

    if (end && n >= end) return this.onEnded()
  },

  onEnded() {
    // return
    if (this.root.getLoop()) return this.playFromStart()

    this.root.stopTicker()
    this.root.setEnded()
  },

  onPlaying() {
    this.root.setState('playing')
    this.root.startTicker()
  },
}
