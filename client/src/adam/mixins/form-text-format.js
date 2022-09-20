import textFormatItems from '../templates/text-format'
const formatKeys = textFormatItems.map((a) => a.value)

export default {
  data() {
    return {
      textFormatItems,
      textFormatValue: [],
    }
  },

  methods: {
    onTextFormat(arr) {
      formatKeys.forEach((key) => {
        this.item.props[key] = arr.indexOf(key) > -1
      })
    },
  },

  beforeMount() {
    formatKeys.forEach((key) => {
      if (this.item.props[key]) {
        this.textFormatValue.push(key)
      }
    })
  },
}
