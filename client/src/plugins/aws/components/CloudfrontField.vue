<template>
  <v-text-field
    v-bind="{ value }"
    v-on="{ input }"
    label="CloudFront Domain"
    placeholder="xyz.cloudfront.net"
    outlined
  />
  <!-- d3kf7wcbjch3x3.cloudfront.net  https://d3kf7wcbjch3x3.cloudfront.net/ -->
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },
  },

  computed: {
    //
  },

  methods: {
    input(value) {
      value = value.trim()
      if (value.indexOf('://') > -1) {
        value = value.split('://').pop()
      }

      const len = value.length
      if (value.substring(len - 1) === '/') {
        value = value.substring(0, len - 1)
      }

      //   this.$emit('input', value)
      this.$emit('input', value)
    },

    onBlur() {
      //   this.$emit('input', this.parseValue(this.value))
    },

    parseValue(value) {
      value = value.trim()
      if (value.indexOf('://') > -1) {
        value = value.split(':').pop()
      }

      const len = value.length
      if (value.substring(len - 1) === '/') {
        value = value.substring(0, len - 1)
      }

      return value
    },
  },
}
</script>
