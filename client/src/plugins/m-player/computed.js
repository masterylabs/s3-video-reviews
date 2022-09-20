// import getVideoId from 'get-video-id'
// import { getVideo } from '../helpers/video'
import isDark from '@/_/helpers/is-dark'

export default {
  getColor() {
    return this.color || this.defaultColor
  },
  isDark() {
    const color = this.color || this.defaultColor
    // const color
    if (this.dark !== null) return this.dark

    return isDark(color)
    // return this.dark
  },

  // video() {
  //   return getVideo(this.src)
  // },
  canPlay() {
    // remove play button flash on autoplay
    if (this.playerState === 'ready' && this.autoplay) return false

    return ['pause', 'paused', 'ready', 'ended', 'seeked'].includes(
      this.playerState
    )
  },
  canPause() {
    return this.playerReady && !this.canPlay
  },

  activeSlot() {
    return {
      'top-right': !!this.$slots['top-right'],
    }
  },

  showOverlayCenter() {
    // return true
    return !!this.$slots['overlay-center']
    // return !!this.$slots['overlay-center']
  },
}
