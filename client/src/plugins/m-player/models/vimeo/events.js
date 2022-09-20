export default {
  onEnded() {
    if (this.root.getLoop()) {
      return this.playFromStart()
    }

    // has a custom end time
    if (this.root.end) this.pause()

    this.root.setEnded()
  },
}
