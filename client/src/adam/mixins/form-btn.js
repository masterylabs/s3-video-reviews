export default {
  props: {
    disabled: Boolean,
  },
  methods: {
    click() {
      this.$emit('click')
    },
  },
}
