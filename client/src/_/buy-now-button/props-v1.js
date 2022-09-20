export default {
  dark: Boolean,
  light: Boolean,
  paypalPrimaryColor: {
    type: String,
    default: '#053087',
  },
  paypalSecondaryColor: {
    type: String,
    default: '#2B9CDE',
  },
  paypalText: {
    type: Boolean,
    default: true,
  },
  elevation: {
    type: [String, Number],
    default: 0,
  },
  text: {
    type: String,
    default: '',
  },
  textSize: {
    type: [String, Number],
    default: 32,
  },
  height: {
    type: [String, Number],
    default: 45,
  },
  maxWidth: {
    type: [String, Number],
    default: 352,
  },
  fontSize: {
    type: [String, Number],
    default: 20,
  },

  color: {
    type: String,
    default: '#FBC439',
  },
  rounded: {
    type: [String, Boolean],
    default: 'pill',
  },
  mx: {
    type: [String, Number],
    default: 2,
  },
  prefix: {
    type: String,
    default: '',
  },

  // box
  useBox: Boolean,
  boxPadding: {
    type: [String, Number],
    default: 0,
  },
  boxRounded: {
    type: [String, Number],
    default: 0,
  },
  boxElevation: {
    type: [String, Number],
    default: 0,
  },
  boxBorderStyle: {
    type: String,
    default: 'solid',
  },
  boxMx: {
    type: [String, Number],
    default: 'auto',
  },
  boxBorderWidth: {
    type: [String, Number],
    default: 0,
  },
  boxBorderColor: {
    type: String,
    default: '#000000',
  },

  // header
  useHeader: Boolean,
  headerDiscountHighlight: Boolean,
  headerPriceSlashed: Boolean,
  headerPriceText: {
    type: String,
    default: '',
  },
  headerDiscountText: {
    type: [String, Number],
    default: 3,
  },
  headerPaddingX: {
    type: [String, Number],
    default: 3,
  },
  headerPaddingY: {
    type: [String, Number],
    default: 2,
  },
  headerAlign: {
    type: String,
    default: 'center',
  },
  headerJustify: {
    type: String,
    default: 'space-between',
  },
  headerDiscountColor: {
    type: String,
    default: 'red',
  },
  headerDiscountFontWeight: {
    type: String,
    default: 'medium',
  },

  useCards: Boolean,
  cards: {
    type: Array,
    default() {
      return ['visa', 'mastercard', 'amex', 'discovery', 'paypal']
    },
  },
  cardsSize: {
    type: [String, Number],
    default: 30,
  },
  cardsSpacingY: {
    type: [String, Number],
    default: 2,
  },
}
