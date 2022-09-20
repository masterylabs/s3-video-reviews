// import spacingMixin from './spacing'
import widthHeightMixin from './width-height'
import spacingMixin from './spacing'
import { isDark } from '../helpers/color'
export default {
  mixins: [widthHeightMixin, spacingMixin],
  props: {
    dark: {
      type: Boolean,
      default: false,
    },
    light: {
      type: Boolean,
      default: false,
    },
    color: {
      type: String,
      default: null,
    },
    rounded: {
      type: String,
      default: null,
    },
    elevation: {
      type: Number,
      default: null,
    },

    // additional
    hideOverlay: Boolean,
    theme: {
      type: Object,
      default: null,
    },
  },

  computed: {
    sheet() {
      let dark = this.dark
      let light = this.light

      if (this.color && !dark && !light) {
        const darkColor = isDark(this.color)
        if (!darkColor) {
          light = true
        } else {
          dark = true
        }
      }

      const defaultColor = this.dark || this.light ? '' : 'rgba(255,255,255,0)'

      const attrs = {
        dark,
        light: light || this.light,
        color: this.color || defaultColor,
        rounded: this.rounded,
        elevation: this.elevation,
        class: [...this.spacing.class], // 'mx-auto',
        ...this.widthHeight,
      }

      if (this.hideOverlay) {
        attrs.style = 'overflow:hidden'
      }

      return attrs
    },
  },
}
