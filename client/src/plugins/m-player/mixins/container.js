export default {
  data() {
    return {
      overWait: null,
      onContainer: {
        mousemove: this.onMouseMove,
        touchstart: this.onTouchStart,
      },
    }
  },

  computed: {
    containerAttrs() {
      const classList = []
      const style = {}

      if (this.nativeControls) classList.push('m-player-native-controls')

      if (this.maxHeight) {
        style['max-height'] = `${this.maxHeight - 50}px`
      }

      return {
        class: classList,
        style,
      }
    },
  },

  methods: {
    onMouseMove() {
      clearTimeout(this.overWait)
      this.over = true
      this.overWait = setTimeout(() => {
        if (!this.overControls) this.over = false
      }, 1000)
    },
  },
}
