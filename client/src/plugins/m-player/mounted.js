export default function() {
  if (this.muted) this.isMuted = true
  if (this.autoplay) this.isAutoplay = true

  // must be after basics set and before loadPlayer
  if (this.preview) {
    this.isPreview = true
    this.isAutoplay = true
    this.isMuted = true
  }

  this.loadPlayer()
}
