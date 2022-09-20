<template>
  <v-text-field
    :value="value"
    label="File Name"
    v-on="{ input, blur }"
    outlined
  />
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },
  },

  methods: {
    input(value) {
      this.$emit('input', value)
    },
    blur({ target }) {
      const value = target.value.replace(/ /g, '-').toLowerCase()
      this.input(value)
    },
  },
}
</script>
