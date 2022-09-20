import formMixin from './form'
export default {
  mixins: [formMixin],
  data() {
    return {
      locked: false,
      lastVal: 0,
    }
  },
  methods: {
    onInput(n) {
      this.lastVal = n
      if (this.locked) {
        this.items.forEach(({ key }) => {
          this.item.props[key] = n
        })
      }
    },
    onLock(locked) {
      if (locked) {
        this.onInput(this.lastVal)
      }
    },
  },
}
