export default {
  props: {
    // can be boolean or number of seconds
    preview: {
      type: [Boolean, Number, String],
      default: false,
    },
    previewStart: {
      type: [Number, String],
      default: 0,
    },
    previewEnd: {
      type: [Number, String],
      default: 0,
    },
    usePreviewStart: {
      type: Boolean,
      default: null,
    },
    usePreviewEnd: {
      type: Boolean,
      default: null,
    },
  },
  data() {
    return {
      isPreview: false,
      noCenterPlayInPreview: false,
      noControlsInPreview: true,
      loopInPreview: true,
      onPreview: {
        click: this.onPreviewClick,
      },
    }
  },

  computed: {
    previewAttrs() {
      return {}
    },
  },

  methods: {
    getPreviewStart() {
      // is false
      if (this.usePreviewStart !== null && !this.usePreviewStart) {
        return this._getStart()
      }

      if (this.previewStart) return parseFloat(this.previewStart)

      return this._getStart()
    },

    getPreviewEnd() {
      if (this.usePreviewEnd !== null && !this.usePreviewEnd) {
        return this._getEnd()
      }

      if (this.previewEnd) return parseFloat(this.previewEnd)

      if (typeof this.preview === 'number') {
        return parseFloat(this.preview)
      }

      return this._getEnd()
    },

    onPreviewClick() {
      this.isPreview = false
      this.setState('playing')
      // this.playFromStart()
      // this.toggleMute()
      this.player.unmute()

      this.playFromStart()
      // this.video.currentTime = 0
      // this.player.playFromStart()
      this.$emit('preview:end')
    },

    mountPreview() {
      this.isPreview = true
      this.isAutoplay = true
      this.isMuted = true

      // set end time
    },
  },
}
