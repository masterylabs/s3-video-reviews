export default {
  computed: {
    linkField() {
      return {
        checkout: this.item.props.checkout,
        openNew: this.item.props.openNew,
      }
    },
  },

  methods: {
    checkout(value) {
      this.item.props.checkout = value
    },
    openNew(value) {
      this.item.props.openNew = value
    },
  },
}
