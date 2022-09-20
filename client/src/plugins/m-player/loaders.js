import YouTube from './models/youtube/YouTube'
import Vimeo from './models/vimeo/Vimeo'
import Video from './models/video/Video'
import Wistia from './models/wistia/Wistia'
import { getVideo } from './helpers/video'

export default {
  loadPlayer() {
    const video = getVideo(this.src)

    // invalid player
    if (!video.service) {
      if (this.player) this.player.destroy()
      this.$emit('invalid')
      return (this.video = video)
    }

    this.service = video.service

    if (this.autoplay) {
      this.isAutoplay = true
    }

    if (this.emitService) this.$emit('service', video.service)

    if (this.player) {
      if (video.service === this.video.service) {
        return this.player.onVideoChange()
      }

      if (typeof this.player.destroy === 'function') {
        this.player.destroy()
      }
    }

    this.video = video

    // YouTube
    if (video.service === 'youtube') {
      this.player = new YouTube(this)
    }

    // Vimeo
    else if (video.service === 'vimeo') {
      this.player = new Vimeo(this)
    }

    // Video File
    else if (video.service === 'video') {
      this.player = new Video(this)
    }
    else if (video.service === 'hls') {
      this.player = new Video(this, 'hls')
    }

    // Wistia
    else if (video.service === 'wistia') {
      this.player = new Wistia(this)
    }
    this.setSize()
  },
}
// lvk3w9s01y
