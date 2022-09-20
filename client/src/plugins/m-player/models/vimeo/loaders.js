import Player from '@vimeo/player'

export default {
  loadPlayer() {
    var options = {
      id: this.root.video.id,
      controls: this.root.nativeControls ? 1 : 0,
      width: 1280,
      muted: this.root.isMuted ? 1 : 0,
      autoplay: this.root.isAutoplay,
    }

    const player = new Player(this.root.$refs.player, options)

    player.on('loaded', async () => {
      const dur = await player.getDuration()

      const start = this.root.getStart()
      if (start) {
        await this.player.setCurrentTime(start)
      }

      this.root.setReady(dur)
    })

    player.on('play', () => {
      if (this.root.playerState !== 'play') this.root.setState('play')
    })

    player.on('playing', () => {
      this.root.setState('playing')
    })

    player.on('pause', () => {
      if (this.root.playerState === 'ended') return
      if (this.root.playerState !== 'pause') this.root.setState('pause')
    })

    player.on('paused', () => {
      this.root.setState('paused')
    })

    player.on('ended', () => {
      this.onEnded()
    })

    player.on('seeking', () => {
      this.root.setState('seeking')
    })

    player.on('seeked', () => {
      this.root.setState('seeked')
    })

    player.on('timeupdate', ({ seconds }) => {
      const end = this.root.getEnd()
      if (end) {
        if ((end && seconds >= end) || seconds === this.root.duration) {
          this.pause()
          this.onEnded()
          return
        }
      }
      this.root.setCurrentTime(seconds)
    })

    /*
		EVENTS
	play
	playing
pause
ended
	timeupdate
progress
seeking
seeked
texttrackchange
chapterchange
cuechange
cuepoint
volumechange
playbackratechange
bufferstart
bufferend
error
- loaded
durationchange
fullscreenchange
qualitychange
camerachange
resize
enterpictureinpicture
leavepictureinpicture
 */

    this.player = player
  },
}
