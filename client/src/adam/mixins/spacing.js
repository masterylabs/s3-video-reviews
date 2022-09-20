import { spacing } from './props'

const keys = Object.keys(spacing)

export default {
  props: {
    ...spacing,
  },

  computed: {
    spacing() {
      const value = {
        class: [],
      }

      keys.forEach((key) => {
        if (this[key]) {
          value.class.push(`${key}-${this[key]}`)
        }
      })

      return value
    },

    spacingClass() {
      let str = ''
      keys.forEach((key) => {
        if (this[key] !== null) {
          str += `${key}-${this[key]} `
        }
      })

      return str
    },
  },
}
