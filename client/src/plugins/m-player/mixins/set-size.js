export default {
  data() {
    return {
      playerWidth: null,
      playerHeight: null,
    }
  },

  methods: {
    setSize() {
      this.playerWidth = this.$refs.container.clientWidth
      this.playerHeight = this.$refs.container.clientHeight
    },
  },
}
