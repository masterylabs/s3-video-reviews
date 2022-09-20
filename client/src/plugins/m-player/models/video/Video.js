import events from './events'
import loaders from './loaders'
import methods from './methods'

class Video {
  playOnSeeked = false

  constructor(root, videoType = '') {
    this.root = root
    this.videoType = videoType
    // this.video

    this.loadVideo()
  }
}

Object.assign(Video.prototype, events)
Object.assign(Video.prototype, loaders)
Object.assign(Video.prototype, methods)

export default Video
