<template>
  <v-color-picker
    class="mx-auto"
    :value="value || defaultValue"
    mode="hexa"
    hide-canvas
    hide-inputs
    hide-mode-switch
    hide-sliders
    show-swatches
    :swatches="swatches"
    @input="onInput"
  />
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },
    defaultValue: {
      type: String,
      default: '#9E9E9E',
    },
  },

  data() {
    return {
      swatches: [
        //
        ['#F44336', '#2196F3', '#8BC34A', '#FF5722'],
        ['#E91E63', '#03A9F4', '#CDDC39', '#795548'],
        ['#9C27B0', '#00BCD4', '#FFEB3B', '#607D8B'],
        ['#673AB7', '#009688', '#FFC107', '#9E9E9E'],
        ['#3F51B5', '#4CAF50', '#FF9800', '#000000'],
      ],
    }
  },

  methods: {
    onInput(color) {
      this.$emit('input', color)
    },
  },
}
</script>
