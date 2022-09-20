export default {
  data() {
    return {
      overControlsWait: null,
      overControls: false,
      onControls: {
        mouseenter: this.onEnterControls,
        mouseleave: this.onLeaveControls,
      },
    }
  },
  computed: {
    showControls() {
      if (this.nativeControls) return false

      if (this.lockControls) return true

      if (this.isPreview) return !this.noControlsInPreview

      return this.over || this.mobileControlsShow
    },

    controlsAttr() {
      const dark = this.isDark
      return {
        height: this.controlsHeight,
        color: this.getColor,
        dark,
        light: !dark,
      }
    },
  },

  methods: {
    onEnterControls() {
      clearTimeout(this.overWait)
      clearTimeout(this.overControlsWait)
      this.overControls = true
    },
    onLeaveControls() {
      const wait = this.$isMobile ? 3000 : 1000
      clearTimeout(this.overControlsWait)
      this.overControlsWait = setTimeout(() => {
        this.overControls = false
        this.onMouseMove() // trigger hide controls
      }, wait)
    },
  },
}
