import { findItem } from '../helpers/find'

export default {
  props: {
    index: {
      type: Number,
      default: null,
    },
    last: Boolean,
    id: {
      type: String,
      required: true,
    },
    children: {
      type: Array,
      default() {
        return []
      },
    },
  },

  computed: {
    item: {
      get() {
        return findItem(this.$store.getters['adam/page'].body, this.id)
      },
    },
  },

  methods: {
    addChild(type) {
      this.$store.commit('adam/ADD_CHILD', { id: this.id, type })
    },
  },
}
