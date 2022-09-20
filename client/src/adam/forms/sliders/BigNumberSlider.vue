<template>
  <v-slider
    v-bind="{ value, label, min, max, hideDetails }"
    thumb-label
    @input="onInput"
  >
    <template v-slot:append>
      <span class="primary--text mt-1"> {{ value }}</span>
    </template>
  </v-slider>
</template>

<script>
  export default {
    props: {
      value: {
        type: Number,
        default: undefined,
      },
      label: {
        type: String,
        default: '',
      },
      min: {
        type: Number,
        default: 0,
      },
      max: {
        type: Number,
        default: 1000,
      },
      defaultValue: {
        type: Number,
        default: undefined,
      },
      hideDetails: Boolean,
    },

    methods: {
      onInput(n) {
        if (n === this.min && typeof this.value === 'undefined') {
          n = this.defaultValue || Math.floor(this.max / 2)
        }

        this.$emit('input', n)
      },
    },
  }
</script>
