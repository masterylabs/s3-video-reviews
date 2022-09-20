export default {
  props: {
    paypalText: Boolean,
    height: 45,
    width: 352,
    color: {
      type: String,
      default: '#FBC439',
    },
    textColor: {
      type: String,
      default: '#000000',
    },
    prefix: {
      type: String,
      default: 'Pay with',
    },
    prefixIcon: {
      type: String,
      default: '',
    },
    text: {
      type: String,
      default: '',
    },
    fontSize: {
      type: [String, Number],
      default: 20,
    },
  },
}
