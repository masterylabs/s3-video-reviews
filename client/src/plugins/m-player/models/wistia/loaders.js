/**
 *
 * Embed Options
 * https://wistia.com/support/developers/embed-options
 *
 * Events
 * https://wistia.com/support/developers/player-api#events
 *
 */

import { domScriptExists } from '../../helpers/dom'

export default {
  loadPlayer() {
    this.loadHeaderScript()

    const id = this.root.video.id

    this.root.$refs.player.classList.forEach((name) => {
      if (name.indexOf('wistia_') === 0) {
        this.root.$refs.player.classList.remove(name)
      }
    })

    this.root.$refs.player.classList.add(`wistia_embed`)
    this.root.$refs.player.classList.add(`wistia_async_${id}`)

    const playerColor = this.root.color
      ? this.root.color.substring(1)
      : '000000'

    const options = {
      videoFoam: true,
      playerColor,
      // plugin: {
      //   'requireEmail-v1': {
      //     lowerText: 'Thanks in advance!',
      //   },
      // },
    }

    const onWistiaLoaded = () => {
      window._wq.push({
        id,
        options,
        onReady: (player) => {
          this.player = player

          this.loadPlayerEvents()

          // set ready
          const dur = player.duration()
          this.root.setReady(dur)
        },
      })
    }

    if (window._wq) return onWistiaLoaded()

    const wait = setInterval(() => {
      if (window._wq) {
        clearInterval(wait)
        onWistiaLoaded()
      }
    }, 100)
  },

  loadPlayerEvents() {
    this.player.bind('play', this.onPlay)
    this.player.bind('pause', this.onPause)
    this.player.bind('end', this.onEnd)
    this.player.bind('timechange', this.root.setCurrentTime)
  },

  loadHeaderScript() {
    const src = '//fast.wistia.com/assets/external/E-v1.js'

    if (!domScriptExists(src)) {
      const js = document.createElement('script')
      js.type = 'text/javascript'
      js.src = src
      document.getElementsByTagName('head')[0].appendChild(js)
    }
  },
}
