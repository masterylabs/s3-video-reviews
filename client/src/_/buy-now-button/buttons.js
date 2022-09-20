export default [
  {
    name: 'Basic',
    attrs: {
      useRegularPrice: true,
      useSpecialPrice: true,
      usePaypalText: true,

      height: 45,
      maxWidth: 352,
      fontSize: 20,
      color: '#FBC439',
      rounded: 'pill',
      mx: 'auto',
      prefix: 'Pay with',

      regularPrice: {},
      specialPrice: {},
      header: {
        align: 'center',
        justify: 'space-between',
      },

      // paypalText: true,
    },
  },
]
