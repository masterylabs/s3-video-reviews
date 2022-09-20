export default {
  onReady() {
    this.setSize()
    this.$emit('ready', this.duration)
  },

  onVideoChange() {
    //
  },

  onPlay() {
    this.$emit('play')
  },
}
