// import captions from './_captions'
// import player from './_player'
// import ticker from './_ticker'

import events from './events'
import loaders from './loaders'
import methods from './methods'

class YouTube {
  root = {} // master player, or main player
  player = {}
  on = {}

  gettingCurrentTime = false

  constructor(player) {
    this.root = player

    this.loadPlayer()
  }
}

// Object.assign(YouTube.prototype, captions)
// Object.assign(YouTube.prototype, player)
// Object.assign(YouTube.prototype, ticker)

Object.assign(YouTube.prototype, events)
Object.assign(YouTube.prototype, loaders)
Object.assign(YouTube.prototype, methods)

export default YouTube
