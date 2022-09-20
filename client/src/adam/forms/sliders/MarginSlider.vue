<template>
  <v-slider
    v-model="model"
    v-bind="{ hideDetails, label, disabled }"
    min="-16"
    max="16"
    thumb-label
    @input="onInput"
    @start="sliding = true"
    @end="sliding = false"
  >
    <!-- <template v-slot:append> {{ value }}, {{ sliding }} </template> -->
  </v-slider>
</template>

<script>
  export default {
    props: {
      disabled: Boolean,
      hideDetails: Boolean,
      value: {
        type: [String, Number],
        default: 0,
      },
      label: {
        type: String,
        default: '',
      },
    },

    data() {
      return {
        model: 0,
        sliding: false,
      }
    },

    beforeMount() {
      if (this.value) this.setValue()
    },

    methods: {
      onInput(value) {
        if (value < 0) {
          value = 'n' + value.toString().substring(1)
        }
        this.$emit('input', value)
      },
      setValue() {
        if (typeof this.value === 'string') {
          this.model = 0 - parseInt(this.value.substring(1))
        } else {
          this.model = this.value || 0
        }
      },
    },

    watch: {
      value() {
        if (!this.sliding) this.setValue()
      },
    },
  }
</script>
