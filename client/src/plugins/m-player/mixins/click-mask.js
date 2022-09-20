export default {
  data() {
    return {
      onClickMask: {
        click: this.useTogglePlay,
      },
    }
  },

  computed: {
    useClickMask() {
      return true
    },
  },
}
