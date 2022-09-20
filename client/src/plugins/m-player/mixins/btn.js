export default {
  props: {
    playerState: {
      type: String,
      default: '',
    },
    rounded: {
      type: String,
      default: '',
    },
    btn: {
      type: Object,
      default() {
        return {}
      },
    },
    icon: {
      type: Object,
      default() {
        return {}
      },
    },
    maxHeight: {
      type: [String, Number],
      default: null,
    },
  },

  methods: {
    click() {
      this.$emit('click')
    },
  },
}
