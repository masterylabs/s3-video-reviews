// import youtube from './youtube'

export default {
  on(name, func) {
    if (!this.onEvents[name]) {
      this.onEvents[name] = []
    }
    this.onEvents[name].push(func)
  },

  callOnEvent(name, e = null) {
    if (!this.onEvents[name]) return

    this.onEvents[name].forEach((func) => {
      func(e)
    })
  },

  play() {
    if (this.playerState === 'ended') {
      if (this.noReplay) return

      if (this.emitPlay) this.$emit('play')
      this.$emit('reload')

      return this.playFromStart()
    }

    if (this.emitPlay) this.$emit('play')

    this.setState('play')

    this.player.play()

    this.onPlay()
  },
  pause() {
    this.setState('pause')
    this.player.pause()
  },

  useTogglePlay() {
    this.togglePlay() 
    this.player.unmute()
  },

  togglePlay() {
    this.callOnEvent('toggle-play')

    if (this.canPlay) {
      this.play()
      this.$emit('click:play')
    } else if (!this.noPause) {
      this.pause()
    }
  },

  seekTo(n) {
    this.player.seekTo(n)
  },

  // may beed some work
  seekToAndPlay(n) {
    this.player.seekToAndPlay(n)
  },

  playFromStart() {
    // need this for mobile fix in preview mode
    // this.player.playFromStart() 
    const start = this.getStart()
    if(this.service === 'hls' || this.service === 'video') {
      this.player.video.currentTime = start 
    } else {
      this.player.playFromStart() 
    }
    
  },
  // youtube,

  toggleMute() {
    if (this.isMuted) this.player.unmute()
    else this.player.mute()
  },

  // dev
  testClick() {
    if (this.$route.name === 'test-sub') {
      return this.$router.push({ name: 'test' })
    }
    const id = (Math.random() + 1).toString(36).substring(7)
    this.$router.push({ name: 'test-sub', params: { id } })
  },
}
