<template>
  <v-text-field
    :value="value"
    :hide-details="hideDetails"
    label="CloudFront"
    v-on="{ input }"
    outlined
    append-icon="mdi-open-in-new"
    @click:append="open"
  />
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    hideDetails: Boolean,
    value: {
      type: String,
      default: '',
    },
  },
  computed: {
    ...mapGetters({
      region: 'adam/bucketRegion',
    }),
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
    open() {
      window.open(
        `https://${this.region}.console.aws.amazon.com/cloudfront/v3/home#/distributions`
      )
    },
  },
}
</script>
