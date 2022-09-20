export default {
  getStart() {
    // const end = this.getEnd()
    // const start = this.getPreviewStart()

    if (this.isPreview) {
      return this.getPreviewStart()
    }

    // if (this.useStart === null || this.useStart) {
    //   return this.start || 0
    // }

    // return 0
    return this._getStart()
  },

  // direct get start (underscore skips all mixins)
  _getStart() {
    if (this.useStart === null || this.useStart) {
      return this.start || 0
    }

    return 0
  },

  getEnd() {
    if (this.isPreview) return this.getPreviewEnd()

    return this._getEnd()
  },

  _getEnd() {
    if (this.useEnd === null || this.useEnd) {
      if (this.end) return this.end
    }

    return null
  },

  getLoop() {
    if (this.isPreview) return this.loopInPreview
    return this.loop || 0
  },
}
