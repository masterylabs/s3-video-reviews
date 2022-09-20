import { findItem, findParent } from '../helpers/find'
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
    blockId: {
      type: String,
      default: null,
    },
    parentId: {
      type: String,
      default: undefined,
    },
    parentType: {
      type: String,
      default: '',
    },
  },

  computed: {
    item: {
      get() {
        return findItem(this.$store.getters['adam/page'].body, this.id)
      },
    },
    parent() {
      return findParent(this.$store.getters['adam/page'].body, this.id)
    },
  },

  methods: {
    clone() {
      this.$store.commit('adam/CLONE', this.id)
    },
  },
}
