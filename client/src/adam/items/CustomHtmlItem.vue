<template>
  <div :class="textAlign ? `text-${textAlign}` : ''">
    <span v-html="contents"></span>
  </div>
</template>

<script>
import { decode } from 'js-base64'

export default {
  props: {
    isPreview: Boolean,
    theme: {
      type: Object,
      default: null,
    },
    id: {
      type: String,
      required: true,
    },
    textAlign: {
      type: String,
      default: '',
    },
    htmlContent: {
      type: String,
      default: '',
    },
  },

  computed: {
    contents() {
      return this.htmlContent ? decode(this.htmlContent) : ''
    },
  },
}
</script>
