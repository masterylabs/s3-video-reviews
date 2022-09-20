<template>
  <v-row align="center" justify="center" no-gutters>
    <component
      v-for="card in cards"
      :key="card"
      :is="`buy-now-button-${card}`"
      :width="width"
      :height="height"
      :class="`mx-${spacing}`"
    />
  </v-row>
</template>

<script>
  export default {
    props: {
      width: {
        type: [Number, String],
        default: 40,
      },
      height: {
        type: [Number, String],
        default: 26,
      },
      paypal: {
        type: [Boolean, String],
        default: false,
      },
      spacing: {
        type: [String, Number],
        default: 2,
      },
      cards: {
        type: Array,
        default() {
          return ['visa', 'mastercard', 'amex', 'discovery', 'paypal']
        },
      },
    },
  }
</script>
