import YouTubePlayer from 'youtube-player'
import { getplayerVars, getPlayerState } from './helpers'

export default {
  loadPlayer() {
    const args = {
      playerVars: {
        ...getplayerVars(),
        cc_load_policy: 0,
        mute: this.root.isMuted ? 1 : 0,
        autoplay: this.root.isAutoplay,
        controls: 0,
        start: this.root.getStart() || 0,
      },
      videoId: this.root.video.id,
      width: 1280,
      height: 720,
    }

    // debug
    // args.playerVars.mute = 1
    // args.playerVars.controls = 1

    const player = YouTubePlayer(this.root.$refs.player, args)

    player.on('ready', ({ target }) => {
      const dur = target.getDuration()
      this.root.setReady(dur)
    })

    player.on('stateChange', ({ data }) => {
      const state = getPlayerState(data)

      if (state === 'playing') {
        this.onPlaying()
      } else if (state === 'ended') {
        this.onEnded()
      } else if (['paused', 'seeked'].includes(state)) {
        this.root.setState(state)
        this.onTicker()
        this.root.stopTicker()
      } else {
        this.onTicker()
      }

      if (this.on[state]) {
        this.on[state]()
        this.on[state] = null
      }
    })

    this.player = player
  },
}
