<template>
  <v-slider
    v-bind="{ value, label, hideDetails, max }"
    v-on="{ input }"
    thumb-label
  >
    <template v-slot:append>
      <span v-if="value" class="primary--text">{{ value }}</span>
    </template>
  </v-slider>
</template>

<script>
  export default {
    props: {
      hideDetails: Boolean,
      value: {
        type: Number,
        default: 0,
      },
      label: {
        type: String,
        default: '',
      },
      max: {
        type: String,
        default: '12',
      },
    },

    methods: {
      input(n) {
        if (n === 0) {
          n = null
        }
        this.$emit('input', n)
      },
    },
  }
</script>
