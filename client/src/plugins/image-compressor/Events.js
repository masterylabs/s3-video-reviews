export default {
  onImageLoad() {
    this.source.width = this.$refs.image.naturalWidth
    this.source.height = this.$refs.image.naturalHeight
  },

  onBgColor(value) {
    this.bgColor = value
  },
  input(level) {
    const value = (80 - level * 2) * 0.01
    this.form.quality = parseFloat(value.toFixed(2))
    this.onForm()
  },

  onCompress() {},

  onForm() {
    // wait
    if (!this.isReady) {
      return
    }
    this.compress()
  },
}
