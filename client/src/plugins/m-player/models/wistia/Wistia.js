import events from './events'
import loaders from './loaders'
import methods from './methods'

class Wistia {
  constructor(root) {
    this.root = root

    this.loadPlayer()
  }
}

Object.assign(Wistia.prototype, events)
Object.assign(Wistia.prototype, loaders)
Object.assign(Wistia.prototype, methods)

export default Wistia
