export default {
  data() {
    return {
      mobileDebug: 'na',
      mobilePreviewStarted: false,
    }
  },

  methods: {
    onMobileReady() {
      // this.mobileDebug = `ready:${this.isAutoplay}`
      if (this.preview || this.autoplay || this.isAutoplay) {
        this.mobileDebug = `ready:${this.isAutoplay}`
        this.player.mute()
        setTimeout(() => {
          this.player.play()
        })
      }
    },

    onTouchStart() {
      if (this.isPreview) return this.onPreviewClick()

      // not working
      // if (['ready', 'ended', 'paused'].includes(this.playerState)) {
      //   // return this.play()
      // }
    },
  },

  // mounted() {
  //   this.mobileDebug = 'mounted'
  //   // const wait = setInterval(() => {
  //   //   if (this.playerState === 'ready' && this.isAutoplay) {
  //   //     this.mobileDebug = 'ready'
  //   //     this.player.mute()
  //   //     this.player.play()
  //   //     clearInterval(wait)
  //   //   }
  //   // }, 1500)
  // },
}
