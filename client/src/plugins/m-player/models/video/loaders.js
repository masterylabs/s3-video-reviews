import Hls from 'hls.js'

export default {
  loadVideo() {
    const video = document.createElement('video')

    this.root.$refs.player.appendChild(video)

    video.src = this.root.src

    if (this.videoType && this.videoType === 'hls') {
      video.setAttribute('type', 'application/x-mpegURL')
      if (Hls.isSupported()) {
        var hls = new Hls()
        hls.loadSource(video.src)
        hls.attachMedia(video)

        if (this.root.poster) {
          video.poster = this.root.poster
        }
      } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        // not supported
      }
    } else {
      video.type = 'video/mp4'

      const props = ['src', 'poster']

      props.forEach((k) => {
        if (this.root[k]) video[k] = this.root[k]
      })
    }

    if (this.root.isMuted) video.muted = 1
    if (this.root.isAutoplay) video.autoplay = 1
    if (this.root.playsinline) video.playsinline = 1
    if (this.root.nativeControls) video.controls = 1

    video.addEventListener('loadedmetadata', () => {
      this.root.mobileDebug = 'loadedmetadata'
      this.onReady()
    })

    video.addEventListener('play', () => {
      if (this.root.playerState !== 'play') this.root.setState('play')
    })

    video.addEventListener('playing', () => {
      this.root.setState('playing')
    })

    video.addEventListener('pause', () => {
      if (this.playOnSeeked) return
      this.onPause()
    })

    video.addEventListener('ended', () => {
      this.onEnded()
    })

    video.addEventListener('seeked', () => {
      this.onSeeked()
    })

    video.addEventListener('timeupdate', () => {
      this.onTimeUpdate()
    })

    this.video = video
  },
}
