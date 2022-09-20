// import captions from './_captions'
// import player from './_player'
// import ticker from './_ticker'

import events from './events'
import loaders from './loaders'
import methods from './methods'

class Vimeo {
  root = {} // master player, or main player
  player = {}

  gettingCurrentTime = false

  constructor(player) {
    this.root = player

    this.loadPlayer()
  }
}

// Object.assign(YouTube.prototype, captions)
// Object.assign(YouTube.prototype, player)
// Object.assign(YouTube.prototype, ticker)

Object.assign(Vimeo.prototype, events)
Object.assign(Vimeo.prototype, loaders)
Object.assign(Vimeo.prototype, methods)

export default Vimeo
