export default {
  props: {
    bold: Boolean,
    highlight: Boolean,
    italic: Boolean,
    underline: Boolean,
    textAlign: {
      type: String,
      default: 'center',
    },
    textColor: {
      type: String,
      default: '',
    },
    textSize: {
      type: String,
      default: '',
    },
  },

  computed: {
    text() {
      const value = {
        style: { color: this.textColor },
        class: [`text-${this.textSize} text-${this.textAlign}`],
      }

      if (this.bold) value.class.push('font-weight-black')
      if (this.italic) value.class.push('font-italic')
      if (this.underline) value.class.push('text-decoration-underline')

      return value
    },
  },
}
