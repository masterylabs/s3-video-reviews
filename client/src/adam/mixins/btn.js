import { isDark } from '../helpers/color'
import { spacing } from './props'

export default {
  props: {
    ...spacing,
    openNew: Boolean,
    dark: {
      type: Boolean,
      default: null,
    },
    light: {
      type: Boolean,
      default: null,
    },
    checkout: Boolean,
    block: {
      type: Boolean,
      default: null,
    },
    href: {
      type: String,
      default: '',
    },
    variant: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: '',
    },
    size: {
      type: String,
      default: '',
    },
    src: {
      // own button
      type: String,
      default: '',
    },
    width: {
      type: Number,
      default: null,
    },
    height: {
      type: Number,
      default: null,
    },
    fontSize: {
      type: Number,
      default: null,
    },
    theme: {
      type: Object,
      default: null,
    },
    align: {
      type: String,
      default: 'center',
    },
    // mx: {
    //   type: [String, Number],
    //   default: null,
    // },
  },

  computed: {
    btn() {
      const cl = []

      for (const k in spacing) {
        if (this[k]) {
          cl.push(`${k}-${this[k]}`)
        }
      }

      const theme = this.theme || {}
      const color = this.color || theme.color

      let dark = this.dark
      let light = this.light

      if (color && !dark && !light) {
        const darkColor = isDark(color)
        if (!darkColor) {
          light = true
        } else {
          dark = true
        }
      }

      if (this.dark) {
        dark = true
        light = false
      }
      if (this.light) {
        light = true
        dark = false
      }

      return {
        block: this.block,
        color,
        width: this.width,
        height: this.height,
        depressed: this.variant === 'depressed',
        outlined: this.variant === 'outlined',
        text: this.variant === 'text',
        'x-small': this.size === 'x-small',
        small: this.size === 'small',
        large: this.size === 'large',
        'x-large': this.size === 'x-large',
        // dark,
        // light: !dark,
        dark,
        light: light || this.light,
        class: cl,
      }
    },

    btnText() {
      return {
        style: {
          fontSize: this.fontSize ? `${this.fontSize}px` : '',
        },
      }
    },

    btnIcon() {
      return {
        size: this.fontSize ? Math.floor(this.fontSize * 0.9) : null,
        text: this.variant === 'text',
        'x-small': this.size === 'x-small',
        small: this.size === 'small',
        large: this.size === 'large',
        'x-large': this.size === 'x-large',
      }
    },
  },
  methods: {
    click() {
      this.$emit('message', [
        'link',
        { href: this.href, openNew: this.openNew, checkout: this.checkout },
      ])
    },
  },
}
