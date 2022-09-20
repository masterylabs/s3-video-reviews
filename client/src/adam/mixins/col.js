import valueProps from '../helpers/value-props'

const props = {
  sm: {
    type: [Number, String],
    default: null,
  },
  md: {
    type: [Number, String],
    default: null,
  },
  lg: {
    type: [Number, String],
    default: null,
  },
  xl: {
    type: [Number, String],
    default: null,
  },
  cols: {
    type: [Number, String],
    default: null,
  },
  offset: {
    type: [Number, String],
    default: null,
  },
  alignSelf: {
    type: String,
    default: null,
  },
}

export default {
  props,
  computed: {
    col() {
      return valueProps(this, props)
    },
  },
}
