<template>
  <v-textarea
    v-bind="{ hideDetails, prependInnerIcon }"
    v-model="model"
    :label="label"
    auto-grow
    outlined
    @input="onInput"
    v-on="on"
  ></v-textarea>
</template>

<script>
import { encode, decode } from 'js-base64'
export default {
  props: {
    hideDetails: Boolean,
    value: {
      type: String,
    },
    label: {
      type: String,
    },
    prependInnerIcon: {
      type: String,
      default: '',
    },
    on: {
      type: Object,
      default: null,
    },
  },

  data() {
    return {
      model: '',
    }
  },

  methods: {
    onInput() {
      const value = encode(this.model)
      this.$emit('input', value)
    },
  },

  created() {
    if (this.value) this.model = decode(this.value)
  },
}
</script>
