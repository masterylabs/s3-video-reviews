<template>
  <div :class="href ? 'ml-pointer' : ''">
    <!-- src: {{ src }}, isPreview:{{ isPreview }} -->
    <v-img
      v-bind="{ ...image, src, contain, width, height, maxWidth, maxHeight }"
      v-on="{ click }"
    >
      <slot />
    </v-img>
  </div>
</template>

<script>
export default {
  props: {
    isPreview: Boolean,
    OpenNew: Boolean,
    checkout: Boolean,
    href: {
      type: String,
      default: '',
    },
    src: {
      type: String,
      default: '',
    },
    alt: {
      type: String,
      default: '',
    },
    contain: {
      type: Boolean,
      default: false,
    },
    width: {
      type: Number,
      default: null,
    },
    height: {
      type: Number,
      default: null,
    },
    maxWidth: {
      type: Number,
      default: null,
    },
    maxHeight: {
      type: Number,
      default: null,
    },
    elevation: {
      type: Number,
      default: null,
    },
    grayscale: {
      type: Number,
      default: null,
    },
    rounded: {
      type: String,
      default: null,
    },
    // filter: {
    //   type: String,
    //   default: '',
    // },
    position: {
      type: String,
      default: 'center center',
    },
    rotate: {
      type: Number,
      default: null,
    },
  },

  computed: {
    image() {
      const item = { class: [], style: {} }

      if (this.grayscale) {
        item.style.filter = `grayscale(${this.grayscale}%)`
      }

      if (this.elevation) {
        item.class.push(`elevation-${this.elevation}`)
      }

      if (this.rounded) {
        item.class.push(`rounded-${this.rounded}`)
      }

      if (this.rotate) {
        item.style.transform = 'rotate(40deg)'
      }

      return item
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
</script>
